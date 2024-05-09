<?php

namespace App\Http\Controllers;

use App\Http\Requests\CotisationMensuelRequest;
use App\Http\Requests\CotisationMensuelYearRequest;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\CotisationSocialMensuel;
use App\Models\CotisationSocialMensuels;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class CotisationSocialMensuelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CotisationMensuelYearRequest $request)
    {
        if ($request->ajax()) {
            $resultats = CotisationSocialMensuel::selectRaw(
                'CONCAT(personnels.nom, " ", personnels.prenom) AS personnel,
                SUM(CASE WHEN MONTH(cotisation_social_mensuels.mois) = 1 THEN 3000 ELSE 0 END) AS jan,
                SUM(CASE WHEN MONTH(cotisation_social_mensuels.mois) = 2 THEN 3000 ELSE 0 END) AS fev,
                SUM(CASE WHEN MONTH(cotisation_social_mensuels.mois) = 3 THEN 3000 ELSE 0 END) AS mars,
                SUM(CASE WHEN MONTH(cotisation_social_mensuels.mois) = 4 THEN 3000 ELSE 0 END) AS avril,
                SUM(CASE WHEN MONTH(cotisation_social_mensuels.mois) = 5 THEN 3000 ELSE 0 END) AS mai,
                SUM(CASE WHEN MONTH(cotisation_social_mensuels.mois) = 6 THEN 3000 ELSE 0 END) AS juin,
                SUM(CASE WHEN MONTH(cotisation_social_mensuels.mois) = 7 THEN 3000 ELSE 0 END) AS juillet,
                SUM(CASE WHEN MONTH(cotisation_social_mensuels.mois) = 8 THEN 3000 ELSE 0 END) AS aout,
                SUM(CASE WHEN MONTH(cotisation_social_mensuels.mois) = 9 THEN 3000 ELSE 0 END) AS sept,
                SUM(CASE WHEN MONTH(cotisation_social_mensuels.mois) = 10 THEN 3000 ELSE 0 END) AS oct,
                SUM(CASE WHEN MONTH(cotisation_social_mensuels.mois) = 11 THEN 3000 ELSE 0 END) AS nov,
                SUM(CASE WHEN MONTH(cotisation_social_mensuels.mois) = 12 THEN 3000 ELSE 0 END) AS dece'
            )
                ->join('personnels', 'personnels.id', '=', 'cotisation_social_mensuels.personnel_id')
                ->when(isset($request->annee), function ($query) use ($request) {
                    return $query->whereYear('cotisation_social_mensuels.mois', $request->annee);
                }, function ($query) {
                    return $query->whereYear('cotisation_social_mensuels.mois', date('Y'));
                })
                ->groupBy('personnels.nom', 'personnels.prenom')
                ->get();

            return datatables()->of($resultats)->make(true);
        }
        $routeName = Route::currentRouteName();
        // Extraire le segment principal du nom de la route
        $segments = explode('.', $routeName);
        $mainSegment = $segments[0];
        $personnels = Personnel::all();
        // Si ce n'est pas une requête AJAX, renvoie la vue pour l'affichage normal
        return view('cotisation-social-mensuels.index', compact('mainSegment', 'personnels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CotisationMensuelRequest $request)
    {
        if (Auth::user()->hasAnyRole('Depositaire Comptable', 'Super Admin')) {
            try {
                CotisationSocialMensuel::create($request->validated());
                return response()->json([
                    'success' => true,
                    'message' => 'Paiement effectué.',
                ], 201);
            } catch (\Exception $e) {
                // Retourner une réponse d'erreur en cas d'exception
                return response()->json([
                    'success' => false,
                    'message' => 'Échec de l\'enregistrement.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }
}
