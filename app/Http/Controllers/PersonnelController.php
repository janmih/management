<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonnelRequest;
use App\Http\Requests\PersonnelUpdateRequest;
use App\Models\Personnel;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;


class PersonnelController extends Controller
{
    /**
     * Affiche une liste des ressources.
     */
    public function index(Request $request)
    {
        // Vérifie si la requête est une requête AJAX
        if ($request->ajax()) {
            // Récupère tous les services depuis la base de données
            $personnel = Personnel::with('service');

            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($personnel)
                ->addColumn('service_id', function ($row) {
                    return $row->service->nom;
                })
                ->addColumn('action', function ($row) {
                    $btnEditer = '<button class="btn btn-warning btn-sm mb-3" onclick="openPersonnelModal(\'edit\', ' . $row->id . ')">Éditer</button>';
                    $btnSupprimer = '<button class="btn btn-danger btn-sm mb-3" onclick="deletePersonnel(' . $row->id . ')">Supprimer</button>';
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
        $services = Service::all();

        return view('personnels.index', compact('mainSegment', 'services'));
    }


    /**
     * Stocke un nouveau service dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PersonnelRequest $request)
    {
        // info($request->all());
        try {
            Personnel::create($request->validated());
            // Renvoie une réponse JSON indiquant le succès avec le code de statut 201 (Created)
            return response()->json(['success' => true, 'message' => 'Nouveau personnel créé avec succès'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // En cas d'erreur, renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
            return response()->json(['success' => false, 'message' => 'Erreur lors de la création du personnel', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personnel $personnel)
    {
        // Renvoie les données du personnel au format JSON
        return response()->json($personnel);
    }

    /**
     * Met à jour le personnel spécifié dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Personnel  $personnel
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PersonnelUpdateRequest $request, Personnel $personnel)
    {
        try {
            // Mettre à jour le personnel avec les données du formulaire
            $personnel->update($request->validated());

            // Renvoie une réponse JSON indiquant le succès avec le code de statut 200 (OK)
            return response()->json(['success' => true, 'message' => 'Personnel mis à jour avec succès'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // En cas d'erreur, renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
            return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour du personnel', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personnel $personnel)
    {
        // Supprime le personnel de la base de données
        $personnel->delete();

        // Renvoie une réponse JSON indiquant le succès
        return response()->json(['success' => true, 'message' => 'Personnel supprimé avec succès']);
    }
}
