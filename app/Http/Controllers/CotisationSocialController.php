<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CotisationSocial;
use Illuminate\Support\Facades\Route;

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
                        return $row->mission->observation;
                    } else {
                        return '';
                    }
                    return $row->mission->observation;
                })
                ->addColumn('action', function ($cotisation) {
                    if ($cotisation->status !== 'payé') {
                        return '<button class="btn btn-info mb-3" onclick="payerCotisation(' . $cotisation->id . ')">Payer</button>';
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
        $totalNonPaye = CotisationSocial::where('status', '<>', 'payé')->sum('montant');
        return view('cotisation-socials.index', compact('mainSegment', 'totalNonPaye'));
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
                // Mettez en œuvre la logique de paiement ici
                $cotisation->status = 'payé';
                $cotisation->save();

                return response()->json(['message' => 'Paiement réussi']);
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
