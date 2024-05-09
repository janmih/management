<?php

namespace App\Http\Controllers;

use App\Mail\CotisationMail;
use Illuminate\Http\Request;
use App\Models\CotisationSocial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Jobs\SendMailForCotisationMission;
use Illuminate\Auth\Access\AuthorizationException;

class CotisationSocialController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /// Vérifie si la requête est une requête AJAX
        if ($request->ajax()) {
            // Récupère tous les services depuis la base de données
            $cotisationSocial = CotisationSocial::with('mission');
            // $cotisationSocial = CotisationSocial::with('mission');

            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($cotisationSocial)
                ->addColumn('personnel_id', function ($row) {
                    if ($row->mission && $row->mission->personnel) {
                        return $row->mission->personnel->nom . ' ' . $row->mission->personnel->prenom;
                    } else {
                        return '';
                    }
                })
                ->addColumn('mission_id', function ($row) {
                    if ($row->mission && $row->mission->observation) {
                        $dd = date('d-m-Y', strtotime($row->mission->date_debut));
                        $df = date('d-m-Y', strtotime($row->mission->date_fin));
                        return $row->mission->observation . PHP_EOL . " du " . $dd . " au " . $df;
                    } else {
                        return '';
                    }
                })
                ->addColumn('action', function ($cotisation) {
                    if ($cotisation->status !== 'payé') {
                        if (Auth::user()->hasAnyRole('Trésorier', 'Super Admin')) {
                            return '<button class="btn btn-info mb-3" onclick="payerCotisation(' . $cotisation->id . ')">Payer</button>';
                        }
                    } else {
                        return '<button class="btn btn-success mb-3" disabled>Payé</button>';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $routeName = Route::currentRouteName();
        // Extraire le segment principal du nom de la route
        $segments = explode('.', $routeName);
        $mainSegment = $segments[0];
        // Si ce n'est pas une requête AJAX, renvoie la vue pour l'affichage normal
        $totalPaye = CotisationSocial::where('status', '=', 'payé')->sum('montant');
        return view('cotisation-socials.index', compact('mainSegment', 'totalPaye'));
    }

    /**
     * Marquer une cotisation comme payée.
     *
     * @param  Request  $request
     * @param  CotisationMissionSocial  $cotisation
     * @return \Illuminate\Http\JsonResponse
     */
    public function payerCotisation(CotisationSocial $cotisation)
    {
        try {
            // Vérifier si la cotisation n'est pas déjà payée
            if ($cotisation->status !== 'payé') {
                $cotisation->status = 'payé';
                $cotisation->save();
                $dates = date('d-m-Y', strtotime($cotisation->mission->date_debut)) . ' au ' . date('d-m-Y', strtotime($cotisation->mission->date_fin));
                $to = $cotisation->mission->personnel->email;
                $montant = $cotisation->montant;
                $names = $cotisation->mission->personnel->full_name;
                SendMailForCotisationMission::dispatch($to, $dates, $montant, $names);
                return response()->json(['message' => "Paiement vaidé"]);
            } else {
                // La cotisation est déjà payée, renvoyer un message approprié
                return response()->json(['message' => 'La cotisation est déjà payée'], 422);
            }
        } catch (\Exception $e) {
            // Gérer toute exception survenue pendant le processus de paiement
            return response()->json(['message' => 'Erreur lors du paiement : ' . $e->getMessage()], 500);
        }
    }
}
