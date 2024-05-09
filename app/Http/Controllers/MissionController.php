<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CotisationSocial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MissionRequest;
use App\Jobs\SendMailForMissionJob;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Access\AuthorizationException;

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
                    if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin', 'Trésorier', 'Secrétaire')) {
                        $btnEditer = '<button class="btn btn-warning btn-sm mb-3" onclick="openMissionModal(\'edit\', ' . $row->id . ')">Éditer</button>';
                        $btnSupprimer = '<button class="btn btn-danger btn-sm mb-3" onclick="deleteMission(' . $row->id . ')">Supprimer</button>';
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

        return view('missions.index', compact('mainSegment', 'personnels'));
    }


    /**
     * Enregistre une nouvelle mission avec une cotisation associée.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MissionRequest $request)
    {
        if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin', 'Trésorier', 'Secrétaire')) {
            try {
                // Validation des champs
                $validatedData = $request->validated();

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
                $person = Mission::with('personnel')->find($mission->id)->first();
                $to = $person->personnel->email;
                $fullName = $person->personnel->nom . ' ' . $person->personnel->prenom;
                $date_debut = $validatedData['date_debut'];
                $date_fin = $validatedData['date_fin'];
                $lieu = $validatedData['lieu'];
                $observations = $validatedData['observation'];
                SendMailForMissionJob::dispatch($to, $fullName, $date_debut, $date_fin, $lieu, $observations);
                // Renvoie une réponse JSON indiquant le succès avec le code de statut 201 (Created)
                return response()->json(['success' => true, 'message' => 'Créé avec succès'], Response::HTTP_CREATED);
            } catch (\Exception $e) {
                // En cas d'erreur, annule la transaction et renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Erreur lors de la création', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mission $mission)
    {
        if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin', 'Trésorier', 'Secrétaire')) {
            return response()->json($mission);
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }

    /**
     * Met à jour la ressource spécifiée dans le stockage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mission  $mission
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MissionRequest $request, Mission $mission)
    {
        if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin', 'Trésorier', 'Secrétaire')) {
            try {

                $validatedData = $request->validated();
                // Démarre une transaction pour s'assurer que toutes les opérations sont exécutées avec succès
                DB::beginTransaction();

                // Vérifie si le statut de la cotisation sociale n'est pas "payé"
                $cotisationSocial = CotisationSocial::where('mission_id', $mission->id)->first();

                if ($cotisationSocial && $cotisationSocial->status === 'non payé') {
                    // Met à jour la mission avec les données du formulaire
                    $mission->update($request->validated());

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
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mission $mission)
    {
        if (Auth::user()->hasAnyRole('Ressource Humaine', 'Super Admin', 'Trésorier', 'Secrétaire')) {
            $delete = CotisationSocial::find($mission->id)->where('status', 'non payé')->delete();
            if ($delete) {
                $mission->delete();
                return response()->json(['success' => true, 'message' => 'Supprimé avec succès']);
            } else {
                return response()->json(['error' => true, 'message' => 'La cotisation sociale à déja été payé']);
            }
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }
}
