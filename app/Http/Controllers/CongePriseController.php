<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\CongePrise;
use App\Models\CongeCumule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\CongePriseRequest;
use App\Http\Requests\GetCongeRestanteRequest;
use App\Http\Requests\GetYearRequest;
use App\Http\Requests\ValideCongeRequest;
use App\Jobs\CongeNotificationJob;
use Illuminate\Auth\Access\AuthorizationException;

class CongePriseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Vérifie si la requête est une requête AJAX
        if ($request->ajax()) {
            // Récupère tous les services depuis la base de données
            $congeCumule = CongePrise::with('personnel');

            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($congeCumule)
                ->addColumn('personnel_id', function ($row) {
                    return $row->personnel->full_name ?? 'N/A';
                })
                ->addColumn('action', function ($row) {
                    if ($row->status == 'stand by') {
                        if (Auth::user()->hasAnyRole(['SSE', 'SMF', 'SPSS', 'Chefferie', 'Super Admin'])) {
                            $btnValider = '<button class="btn btn-success btn-sm mb-3" onclick="validerConge(' . $row->id . ')"><i class="fas fa-circle-check"></i></button>';
                        } else {
                            $btnValider = '';
                        }
                        $btnEditer = '<button class="btn btn-warning btn-sm mb-3" onclick="openCongePriseModal(\'edit\', ' . $row->id . ')"><i class="fas fa-pen"></i></button>';
                        $btnSupprimer = '<button class="btn btn-danger btn-sm mb-3" onclick="deleteCongePrise(' . $row->id . ')"><i class="fas fa-trash"></i></button>';

                        return $btnValider . ' ' . $btnEditer . ' ' . $btnSupprimer;
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
        if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin')) {
            $personnels = Personnel::all();
        } else {
            $personnels = Personnel::where('email', Auth::user()->email)->get();
        }
        return view('conge-prises.index', compact('mainSegment', 'personnels'));
    }

    public function valideConge(ValideCongeRequest $request)
    {
        if (Auth::user()->hasAnyRole(['SSE', 'SPSS', 'SMF', 'Chefferie', 'Super Admin'])) {
            $validatedData = $request->validated();
            $congePrise = CongePrise::find($validatedData['conge_prise_id']);
            $congePrise->update([
                'status' => 'valide',
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Congé valide',
                'congePrise' => $congePrise
            ]);
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }

    /**
     * Récupère les années associées à un personnel pour mise à jour de la liste déroulante.
     *
     * @param  int  $personnelId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getYears(GetYearRequest $request)
    {
        $validatedData = $request->validated();
        // Récupère les années associées au personnel depuis la base de données
        $years = CongeCumule::where('personnel_id', $validatedData['personnel_id'])->pluck('annee');
        // Crée une chaîne HTML pour les options de la liste déroulante
        $options = '<option value="">Veuillez choisir</option>';
        foreach ($years as $year) {
            $options .= '<option value="' . $year . '">' . $year . '</option>';
        }

        return $options;
    }

    /**
     * Récupère le congé restant associé à un personnel et une année pour mise à jour du champ "conge_restante".
     *
     * @param  int  $personnelId
     * @param  int  $annee
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCongeRestante(GetCongeRestanteRequest $request)
    {
        // Retrieve the validated data
        $validatedData = $request->validated();

        // Retrieve the remaining leave associated with the personnel and year from the database
        $congeRestante = CongeCumule::where('personnel_id', $validatedData['personnel_id'])
            ->where('annee', $validatedData['annee'])
            ->pluck('jour_reste');
        // Récupère le congé restant associé au personnel et à l'année depuis la base de données

        return response()->json($congeRestante);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CongePriseRequest $request)
    {
        try {
            // Valider les données de la requête
            $validatedData = $request->validated();
            $personnels = Personnel::where('id', $validatedData['personnel_id'])->firstOrFail();

            // Calculer le nombre de jours pris à partir de la table conge_cumule
            $congeCumule = CongeCumule::where('personnel_id', $validatedData['personnel_id'])
                ->where('annee', $validatedData['annee'])
                ->firstOrFail();

            $jourPrise = $congeCumule->jour_prise + $validatedData['nombre_jour'];

            // Vérifier si le nombre de jours pris dépasse le nombre total de jours disponibles
            if ($jourPrise > $congeCumule->jour_total) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le nombre de jours pris dépasse le nombre total de jours disponibles.',
                ], 422);
            }

            // Créer une nouvelle instance de la prise de congé
            $newPriseConge = CongePrise::create($validatedData);

            // Mettre à jour le nombre de jours pris dans la table conge_cumule
            $congeCumule->update([
                'jour_prise' => $jourPrise,
                'jour_reste' => $congeCumule->jour_total - $jourPrise,
            ]);

            CongeNotificationJob::dispatch($personnels);

            // Retourner une réponse de succès avec la nouvelle prise de congé
            return response()->json([
                'success' => true,
                'message' => 'Prise de congé enregistrée avec succès.',
                'data' => $newPriseConge,
            ], 201);
        } catch (\Exception $e) {
            // Retourner une réponse d'erreur en cas d'exception
            return response()->json([
                'success' => false,
                'message' => 'Échec de l\'enregistrement de la prise de congé.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CongePrise $congePrise)
    {
        return response()->json($congePrise);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CongePriseRequest $request, CongePrise $congePrise)
    {
        try {
            // Valider les données de la requête
            $validatedData = $request->validate();

            // Mettre à jour la prise de congé
            $congePrise->update($validatedData);

            // Mettre à jour le nombre de jours pris dans la table conge_cumule
            $congeCumule = CongeCumule::where('personnel_id', $congePrise->personnel_id)
                ->where('annee', $congePrise->annee)
                ->firstOrFail();

            // Créer une nouvelle instance de la prise de congé
            $newPriseConge = CongePrise::create($validatedData);

            // Mettre à jour le nombre de jours pris dans la table conge_cumule
            $congeCumule->update([
                'jour_prise' => $validatedData['nombre_jour'],
                'jour_reste' => $congeCumule->jour_total - $validatedData['nombre_jour'],
            ]);

            // Retourner une réponse de succès avec la prise de congé mise à jour
            return response()->json([
                'success' => true,
                'message' => 'Prise de congé mise à jour avec succès.',
                'data' => $congePrise->refresh(), // Rafraîchir les données de la prise de congé
            ]);
        } catch (\Exception $e) {
            // Retourner une réponse d'erreur en cas d'exception
            return response()->json([
                'success' => false,
                'message' => 'Échec de la mise à jour de la prise de congé.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CongePrise $congePrise)
    {
        try {
            // Mettre à jour le nombre de jours restants dans la table conge_cumule
            $congeCumule = CongeCumule::where('personnel_id', $congePrise->personnel_id)
                ->where('annee', $congePrise->annee)
                ->firstOrFail();

            $congeCumule->update([
                'jour_reste' => $congeCumule->jour_reste + $congePrise->nombre_jour, // Ajouter les jours supprimés
                'jour_prise' =>  $congeCumule->jour_prise - $congePrise->nombre_jour
            ]);
            // Supprimer la prise de congé
            $congePrise->delete();

            // Retourner une réponse de succès
            return response()->json([
                'success' => true,
                'message' => 'Prise de congé supprimée avec succès.',
            ]);
        } catch (\Exception $e) {
            // Retourner une réponse d'erreur en cas d'exception
            return response()->json([
                'success' => false,
                'message' => 'Échec de la suppression de la prise de congé.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
