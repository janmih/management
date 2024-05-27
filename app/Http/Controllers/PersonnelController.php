<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Personnel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\PersonnelRequest;
use App\Http\Requests\PersonnelUpdateRequest;
use Illuminate\Auth\Access\AuthorizationException;

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
                    if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin')) {
                        $btnEditer = '<button class="btn btn-warning btn-sm mb-3" onclick="openPersonnelModal(\'edit\', ' . $row->id . ')" title="Éditer"><i class="fas fa-pencil" ></i></button>';
                        $btnSupprimer = '<button class="btn btn-danger btn-sm mb-3" onclick="deletePersonnel(' . $row->id . ')" title="Supprimer"><i class="fas fa-trash"></i></button>';
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
        if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin')) {
            try {
                $validateData = $request->validated();
                $fullName = $validateData['nom'] . ' ' . $validateData['prenom'];
                Personnel::create($validateData);
                User::create([
                    'name' => $fullName,
                    'email' => $request->email,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'role' => 'User',
                    'service_id' => $request->service_id,
                    'remember_token' => Str::random(10),
                ]);

                // Renvoie une réponse JSON indiquant le succès avec le code de statut 201 (Created)
                return response()->json(['success' => true, 'message' => 'Nouveau personnel créé avec succès'], Response::HTTP_CREATED);
            } catch (\Exception $e) {
                // En cas d'erreur, renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
                return response()->json(['success' => false, 'message' => 'Erreur lors de la création du personnel', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personnel $personnel)
    {
        if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin')) {
            // Renvoie les données du personnel au format JSON
            return response()->json($personnel);
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
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
        if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin')) {

            try {
                // Mettre à jour le personnel avec les données du formulaire
                $personnel->update($request->validated());

                // Renvoie une réponse JSON indiquant le succès avec le code de statut 200 (OK)
                return response()->json(['success' => true, 'message' => 'Personnel mis à jour avec succès'], Response::HTTP_OK);
            } catch (\Exception $e) {
                // En cas d'erreur, renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
                return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour du personnel', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personnel $personnel)
    {
        if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin')) {
            // Supprime le personnel de la base de données
            $personnel->delete();

            // Renvoie une réponse JSON indiquant le succès
            return response()->json(['success' => true, 'message' => 'Personnel supprimé avec succès']);
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }
}
