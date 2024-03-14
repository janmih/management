<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CotisationSocial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /// Vérifie si la requête est une requête AJAX
        if ($request->ajax()) {
            // Récupère tous les services depuis la base de données
            $mission = Mission::with('personnel');

            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($mission)
                ->addColumn('personnel_id', function ($row) {
                    return $row->personnel->nom . ' ' . $row->personnel->prenom;
                })
                ->addColumn('action', function ($row) {
                    $btnEditer = '<button class="btn btn-warning btn-sm mb-3" onclick="openMissionModal(\'edit\', ' . $row->id . ')">Éditer</button>';
                    $btnSupprimer = '<button class="btn btn-danger btn-sm mb-3" onclick="deleteMission(' . $row->id . ')">Supprimer</button>';
                    return $btnEditer . ' ' . $btnSupprimer;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $routeName = Route::currentRouteName();
        // Extraire le segment principal du nom de la route
        $segments = explode('.', $routeName);
        $mainSegment = $segments[0];
        // Si ce n'est pas une requête AJAX, renvoie la vue pour l'affichage normal
        $personnels = Personnel::all();

        return view('missions.index', compact('mainSegment', 'personnels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     try {
    //         // Validation des champs
    //         $validatedData = $request->validate([
    //             'personnel_id' => 'required|exists:personnels,id_personnel', // À ajuster en fonction de votre structure
    //             'date_debut' => 'required|date',
    //             'date_fin' => 'required|date|after_or_equal:date_debut',
    //             'observation' => 'nullable|string',
    //             'lieu' => 'required|string',
    //             'nombre_jour' => 'required|integer',
    //             'type' => 'required|string',
    //             // Ajoutez d'autres règles de validation au besoin
    //         ]);

    //         // Crée un nouveau service avec les données du formulaire
    //         Mission::create($validatedData);

    //         // Renvoie une réponse JSON indiquant le succès avec le code de statut 201 (Created)
    //         return response()->json(['success' => true, 'message' => 'Créé avec succès'], Response::HTTP_CREATED);
    //     } catch (\Exception $e) {
    //         // En cas d'erreur, renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
    //         return response()->json(['success' => false, 'message' => 'Erreur lors de la création', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }

    /**
     * Enregistre une nouvelle mission avec une cotisation associée.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validation des champs
            $validatedData = $request->validate([
                'personnel_id' => 'required|exists:personnels,id', // À ajuster en fonction de votre structure
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after_or_equal:date_debut',
                'observation' => 'nullable|string',
                'lieu' => 'required|string',
                'nombre_jour' => 'required|integer',
                'type' => 'required|string',
                // Ajoutez d'autres règles de validation au besoin
            ]);

            // Démarre une transaction pour s'assurer que toutes les opérations sont exécutées avec succès
            DB::beginTransaction();

            // Crée une nouvelle mission avec les données du formulaire
            $mission = Mission::create($validatedData);

            // Détermine le montant en fonction du type de mission
            $montant = ($validatedData['type'] === 'OR') ? 5000 : (($validatedData['type'] === 'PTF') ? 10000 : 0);

            // Crée une nouvelle cotisation_social associée à la mission
            CotisationSocial::create([
                'mission_id' => $mission->id,
                'montant' => $montant,
                'status' => 'non payé',
            ]);

            // Valide toutes les opérations dans la transaction
            DB::commit();

            // Renvoie une réponse JSON indiquant le succès avec le code de statut 201 (Created)
            return response()->json(['success' => true, 'message' => 'Créé avec succès'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // En cas d'erreur, annule la transaction et renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Erreur lors de la création', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mission $mission)
    {
        return response()->json($mission);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Mission $mission)
    // {
    //     try {
    //         $validatedData = $request->validate([
    //             'personnel_id' => 'required|exists:personnels,id_personnel', // À ajuster en fonction de votre structure
    //             'date_debut' => 'required|date',
    //             'date_fin' => 'required|date|after_or_equal:date_debut',
    //             'observation' => 'nullable|string',
    //             'lieu' => 'required|string',
    //             'nombre_jour' => 'required|integer',
    //             'type' => 'required|string',
    //             // Ajoutez d'autres règles de validation au besoin
    //         ]);
    //         // Crée un nouveau service avec les données du formulaire
    //         $mission->update($validatedData);

    //         // Renvoie une réponse JSON indiquant le succès avec le code de statut 201 (Created)
    //         return response()->json(['success' => true, 'message' => 'mis à jour avec succès'], Response::HTTP_CREATED);
    //     } catch (\Exception $e) {
    //         // En cas d'erreur, renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
    //         return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }

    /**
     * Met à jour la ressource spécifiée dans le stockage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Mission $mission)
    {
        try {
            // Validation des champs
            $validatedData = $request->validate([
                'personnel_id' => 'required|exists:personnels,id', // À ajuster en fonction de votre structure
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after_or_equal:date_debut',
                'observation' => 'nullable|string',
                'lieu' => 'required|string',
                'nombre_jour' => 'required|integer',
                'type' => 'required|string',
                // Ajoutez d'autres règles de validation au besoin
            ]);

            // Démarre une transaction pour s'assurer que toutes les opérations sont exécutées avec succès
            DB::beginTransaction();

            // Vérifie si le statut de la cotisation sociale n'est pas "payé"
            $cotisationSocial = CotisationSocial::where('mission_id', $mission->id)->first();

            if ($cotisationSocial && $cotisationSocial->status === 'non payé') {
                // Met à jour la mission avec les données du formulaire
                $mission->update($validatedData);

                // Met à jour le montant de la cotisation sociale en fonction du type de mission
                $montant = ($validatedData['type'] === 'OR') ? 5000 : (($validatedData['type'] === 'PTF') ? 10000 : 0);

                $cotisationSocial->update([
                    'montant' => $montant,
                ]);
            } else {
                DB::rollBack();

                return response()->json(['success' => false, 'message' => 'La cotisaton est déjà payé']);
            }

            // Valide toutes les opérations dans la transaction
            DB::commit();

            // Renvoie une réponse JSON indiquant le succès avec le code de statut 200 (OK)
            return response()->json(['success' => true, 'message' => 'Mis à jour avec succès'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // En cas d'erreur, annule la transaction et renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mission $mission)
    {
        $mission->delete();
        return response()->json(['success' => true, 'message' => 'Supprimé avec succès']);
    }
}
