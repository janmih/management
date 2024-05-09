<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\ReposMedical;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\ReposMedicalRequest;
use Illuminate\Auth\Access\AuthorizationException;

class ReposMedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /// Vérifie si la requête est une requête AJAX
        if ($request->ajax()) {
            // Récupère tous les services depuis la base de données
            $congeCumule = ReposMedical::with('personnel');

            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($congeCumule)
                ->addColumn('personnel_id', function ($row) {
                    return $row->personnel->nom . ' ' . $row->personnel->prenom;
                })
                ->addColumn('action', function ($row) {
                    if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin')) {
                        $btnEditer = '<button class="btn btn-warning btn-sm mb-3" onclick="openReposMedicalModal(\'edit\', ' . $row->id . ')">Éditer</button>';
                        $btnSupprimer = '<button class="btn btn-danger btn-sm mb-3" onclick="deleteReposMedical(' . $row->id . ')">Supprimer</button>';
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
        $personnels = Personnel::all();

        return view('repos-medicals.index', compact('mainSegment', 'personnels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReposMedicalRequest $request)
    {
        if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin')) {

            try {
                // Crée un nouveau service avec les données du formulaire
                ReposMedical::create($request->validated());

                // Renvoie une réponse JSON indiquant le succès avec le code de statut 201 (Created)
                return response()->json(['success' => true, 'message' => 'Créé avec succès'], Response::HTTP_CREATED);
            } catch (\Exception $e) {
                // En cas d'erreur, renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
                return response()->json(['success' => false, 'message' => 'Erreur lors de la création', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReposMedical $reposMedical)
    {
        if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin')) {
            // Renvoie les données du service au format JSON
            return response()->json($reposMedical);
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReposMedicalRequest $request, ReposMedical $reposMedical)
    {
        if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin')) {

            try {
                // Crée un nouveau service avec les données du formulaire
                $reposMedical->update($request->validated());

                // Renvoie une réponse JSON indiquant le succès avec le code de statut 201 (Created)
                return response()->json(['success' => true, 'message' => 'mis à jour avec succès'], Response::HTTP_CREATED);
            } catch (\Exception $e) {
                // En cas d'erreur, renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
                return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReposMedical $reposMedical)
    {
        if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin')) {
            $reposMedical->delete();
            return response()->json(['success' => true, 'message' => 'Supprimé avec succès']);
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }
}
