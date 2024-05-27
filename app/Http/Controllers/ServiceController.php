<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Access\AuthorizationException;

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
                    if (Auth::user()->hasAnyRole(['Ressource Humaine', 'Super Admin', 'Admin'])) {
                        $btnEditer = '<button class="btn btn-warning btn-sm mb-3" onclick="openServiceModal(\'edit\', ' . $row->id . ')" title="Editer"><i class="fas fa-pencil"></i></button>';
                        $btnSupprimer = '<button class="btn btn-danger btn-sm mb-3" onclick="deleteService(' . $row->id . ')" title="Supprimer"><i class="fas fa-trash"></i></button>';
                        return $btnEditer . ' ' . $btnSupprimer;
                    } else {
                        return '';
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
        return view('services.index', compact('mainSegment'));
    }

    /**
     * Stocke un nouveau service dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ServiceRequest $request)
    {
        if (Auth::user()->hasAnyRole(['Ressource Humaine', 'Super Admin'])) {
            try {
                // Crée un nouveau service avec les données du formulaire
                Service::create($request->validated());

                // Renvoie une réponse JSON indiquant le succès avec le code de statut 201 (Created)
                return response()->json(['success' => true, 'message' => 'Nouveau service créé avec succès'], Response::HTTP_CREATED);
            } catch (\Exception $e) {
                // En cas d'erreur, renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
                return response()->json(['success' => false, 'message' => 'Erreur lors de la création du service', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }


    /**
     * Affiche le formulaire d'édition de la ressource spécifiée.
     */
    public function edit(Service $service)
    {
        if (Auth::user()->hasAnyRole(['Ressource Humaine', 'Super Admin'])) {
            return response()->json($service);
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }


    /**
     * Met à jour le service spécifié dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Service  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ServiceRequest $request, Service $service)
    {
        if (Auth::user()->hasAnyRole(['Ressource Humaine', 'Super Admin'])) {
            try {
                // Met à jour les données du service
                $service->update($request->validated());
                // Renvoie une réponse JSON indiquant le succès
                return response()->json(['success' => true, 'message' => 'Service mis à jour avec succès']);
            } catch (\Exception $e) {
                // En cas d'erreur, renvoie une réponse JSON avec un message d'erreur
                return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour du service', 'error' => $e->getMessage()], 500);
            }
        } else {
            throw new AuthorizationException('Vous n\'êtes pas autorisé à accéder à cette ressource.');
        }
    }


    /**
     * Supprime la ressource spécifiée de la base de données.
     */
    public function destroy(Service $service)
    {
        if (Auth::user()->hasAnyRole(['Ressource Humaine', 'Super Admin'])) {
            $service->delete();
            // Renvoie une réponse JSON indiquant le succès
            return response()->json(['success' => true, 'message' => 'Service supprimé avec succès']);
        } else {
            throw new AuthorizationException('Vous n\'êtes pas autorisé à accéder à cette ressource.');
        }
    }
}
