<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class ServiceController extends Controller
{

    /**
     * Affiche une liste des ressources.
     */
    public function index(Request $request)
    {
        // Vérifie si la requête est une requête AJAX
        if ($request->ajax()) {
            // Récupère tous les services depuis la base de données
            $services = Service::all();

            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($services)
                ->addColumn('action', function ($row) {
                    $btnEditer = '<button class="btn btn-warning btn-sm mb-3" onclick="openServiceModal(\'edit\', ' . $row->id . ')">Éditer</button>';
                    $btnSupprimer = '<button class="btn btn-danger btn-sm mb-3" onclick="deleteService(' . $row->id . ')">Supprimer</button>';
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
        return view('services.index', compact('mainSegment'));
    }

    /**
     * Stocke un nouveau service dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Valide les données du formulaire
            $request->validate([
                'nom' => 'required|string|unique:services',
                'description' => 'string',
            ]);

            // Crée un nouveau service avec les données du formulaire
            Service::create($request->all());

            // Renvoie une réponse JSON indiquant le succès avec le code de statut 201 (Created)
            return response()->json(['success' => true, 'message' => 'Nouveau service créé avec succès'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // En cas d'erreur, renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
            return response()->json(['success' => false, 'message' => 'Erreur lors de la création du service', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Affiche le formulaire d'édition de la ressource spécifiée.
     */
    public function edit(Service $service)
    {
        // Renvoie les données du service au format JSON
        return response()->json($service);
    }


    /**
     * Met à jour le service spécifié dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Service $service)
    {
        // Valide les données du formulaire
        $request->validate([
            'nom' => [
                'required',
                'string',
                Rule::unique('services', 'nom')->ignore($service->id, 'id_service')
            ],
            'description' => 'string',
            // Autres règles de validation
        ]);

        try {
            // Met à jour les données du service
            $service->update($request->all());
            // Renvoie une réponse JSON indiquant le succès
            return response()->json(['success' => true, 'message' => 'Service mis à jour avec succès']);
        } catch (\Exception $e) {
            // En cas d'erreur, renvoie une réponse JSON avec un message d'erreur
            return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour du service', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * Supprime la ressource spécifiée de la base de données.
     */
    public function destroy(Service $service)
    {
        // Supprime le service de la base de données
        $service->delete();

        // Renvoie une réponse JSON indiquant le succès
        return response()->json(['success' => true, 'message' => 'Service supprimé avec succès']);
    }
}