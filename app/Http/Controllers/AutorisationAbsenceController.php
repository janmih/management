<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Personnel;
use Illuminate\Http\Request;
use App\Models\AutorisationAbsence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\AutorisatonAbsenceRequest;
use App\Http\Requests\ChangeStatusRequest;
use Illuminate\Auth\Access\AuthorizationException;

class AutorisationAbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Vérifie si la requête est une requête AJAX
        if ($request->ajax()) {
            // Récupère tous les services depuis la base de données
            $autorisationAbsence = AutorisationAbsence::with('personnel:id,nom,prenom');

            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($autorisationAbsence)
                ->addColumn('personnel_id', function ($row) {
                    return $row->personnel->nom . ' ' . $row->personnel->prenom;
                })
                ->addColumn('action', function ($row) {
                    if ($row->status !== 'validated' && $row->status !== 'refused') {
                        if (Auth::user()->hasAnyRole('Chef de service', 'Super Admin')) {
                            $btnValider = '<i onclick="validerAutorisation(' . $row->id . ')" class="btn btn-success btn-sm fa-solid fa-check-to-slot"></i>';
                            $btnRefuser = ' <i class="fa-solid fa-square-xmark btn btn-danger btn-sm" onclick="refuserAutorisation(' . $row->id . ')"></i>';
                            // $btnEditer = '<button class="btn btn-warning btn-sm mb-3" onclick="openautorisationAbsenceModal(\'edit\', ' . $row->id . ')"><i class="fa-solid fa-pen-clip"></i></button>';
                            return $btnValider . ' ' . $btnRefuser;
                        }
                    }
                })
                // ->filter(function ($query) use ($request) {
                //     // Vérifie s'il y a une recherche
                //     if ($request->has('search') && !empty($request->input('search')['value'])) {
                //         $search = $request->input('search')['value'];
                //         // Exclut la colonne "Actions" de la recherche
                //         $query->whereHas('personnel', function ($q) use ($search) {
                //             $q->where('nom', 'like', "%$search%")
                //                 ->orWhere('prenom', 'like', "%$search%");
                //         })->orWhere('date_debut', 'like', "%$search%")
                //             ->orWhere('date_fin', 'like', "%$search%")
                //             ->orWhere('jour_prise', 'like', "%$search%")
                //             ->orWhere('jour_reste', 'like', "%$search%")
                //             ->orWhere('motif', 'like', "%$search%")
                //             ->orWhere('Observation', 'like', "%$search%")
                //             ->orWhere('status', 'like', "%$search%");
                //     }
                // })
                ->rawColumns(['action'])
                ->make(true);
        }

        $routeName = Route::currentRouteName();
        // Extraire le segment principal du nom de la route
        $segments = explode('.', $routeName);
        $mainSegment = $segments[0];

        // Si ce n'est pas une requête AJAX, renvoie la vue pour l'affichage normal
        $personnels = Personnel::select('id', 'nom', 'prenom')->get();

        return view('autorisation-absences.index', compact('mainSegment', 'personnels'));
    }

    /**
     * Obtient le nombre de jours restants pour une autorisation d'absence associée à un personnel et à l'année en cours.
     *
     * @param  int  $personnelId
     * @param  int  $annee
     * @return \Illuminate\Http\Response
     */
    public function getAutorisationRestants($personnelId, $annee)
    {
        // Vérifier si des autorisations d'absence existent pour le personnel donné et l'année en cours
        $autorisationExistante = AutorisationAbsence::where('personnel_id', $personnelId)
            ->whereYear('date_debut', $annee)
            ->exists();

        // Si aucune autorisation d'absence n'existe pour cette année, retourner la valeur par défaut de 15 jours
        if (!$autorisationExistante) {
            return response()->json([15]);
        }

        // Sinon, obtenir le nombre de jours restants pour l'autorisation d'absence associée au personnel et à l'année en cours
        $joursRestants = AutorisationAbsence::where('personnel_id', $personnelId)
            ->whereYear('date_debut', $annee)
            ->orderByDesc('id') // Récupérer le dernier enregistrement basé sur l'ID
            ->value('jour_reste'); // Récupérer uniquement la valeur de jour_reste du dernier enregistrement


        // Retourner les jours restants au format JSON
        return response()->json([$joursRestants]);
    }

    // Méthode pour valider ou refuser une autorisation d'absence
    public function changerStatutAutorisation(ChangeStatusRequest $request)
    {
        if (Auth::user()->hasAnyRole(['SSE', 'SPSS', 'SMF', 'Chefferie', 'Super Admin'])) {
            try {
                $validatedData = $request->validated();
                // Mettre à jour le statut de l'autorisation en fonction de l'action demandée
                $autorisation = AutorisationAbsence::findOrFail($validatedData['id']);
                $autorisation->status = $validatedData['statut'];
                if ($validatedData['statut'] == 'refused') {
                    // Retourner une réponse JSON pour indiquer le succès de l'opération
                    $autorisation->jour_reste += $autorisation->jour_prise;
                    $autorisation->jour_prise -=   $autorisation->jour_prise;
                }
                $autorisation->save();
                // Retourner une réponse JSON pour indiquer le succès de l'opération
                $message = $validatedData['statut'] == 'validated' ? 'Autorisation validée avec succès.' : 'Autorisation refusée avec succès.';
                return response()->json(['success' => true, 'message' => $message], 200);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Une erreur s\'est produite', 'error' => $e->getMessage()], 500);
            }
        } else {
            throw new \Exception('Vous n\'avez pas le droit d\'effectuer cette operation', 403);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(AutorisatonAbsenceRequest $request)
    {
        if (Auth::user()->hasAnyRole('Super Admin', 'Ressource Humaine')) {
            try {
                // Récupérer les données entrantes validées par la classe de requête
                $data = $request->validated();

                // Extraire les champs pertinents de la requête
                $personnelId = $data['personnel_id'];
                $dateDebut = Carbon::parse($data['date_debut']);
                $dateFin = Carbon::parse($data['date_fin']);

                // Vérifier si le personnel a déjà pris 3 jours cette semaine
                $autorisationAbsencesCetteSemaine = AutorisationAbsence::where('personnel_id', $personnelId)
                    ->whereBetween('date_debut', [$dateDebut->startOfWeek(), $dateDebut->endOfWeek()])
                    ->sum('jour_prise');

                // Si le personnel a déjà pris 3 jours cette semaine, renvoyer un message d'erreur
                if ($autorisationAbsencesCetteSemaine + $data['jour_prise'] > 3) {
                    return response()->json(['message' => 'Le personnel a déjà pris 3 jours cette semaine.'], 422);
                }

                // Vérifier si le nombre total de jours d'autorisation d'absence demandés ne dépasse pas 15 jours pour cette année
                $autorisationAbsencesCetteAnnee = AutorisationAbsence::where('personnel_id', $personnelId)
                    ->whereYear('date_debut', $dateDebut->year)
                    ->sum('jour_prise');

                // Si le nombre total de jours demandés dépasse 15 jours pour cette année, renvoyer un message d'erreur
                if ($autorisationAbsencesCetteAnnee + $data['jour_prise'] > 15) {
                    return response()->json(['message' => 'Le nombre total de jours d\'autorisation d\'absence demandés dépasse 15 jours pour cette année.'], 422);
                }

                $data['jour_reste'] = $data['jour_reste'] - $data['jour_prise'];

                // Créer une nouvelle autorisation d'absence avec les données validées
                AutorisationAbsence::create($data);

                // Retourner une réponse JSON indiquant que l'autorisation d'absence a été créée avec succès
                return response()->json(['success' => true, 'message' => 'Autorisation d\'absence créée avec succès.'], 201);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Erreur s\'est produite'], $e->getCode());
            }
        } else {
            throw new AuthorizationException('Vous n\'avez pas la permission d\'effectuer cette action');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AutorisatonAbsenceRequest $autorisationAbsence)
    {
        if (Auth::user()->hasAnyRole(['Ressource Humaine', 'Super Admin'])) {
            return response()->json($autorisationAbsence);
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AutorisatonAbsenceRequest $autorisationAbsence)
    {
        if (Auth::user()->hasAnyRole(['Ressource Humaine', 'Super Admin'])) {

            try {
                // Valider les données de la requête
                $validatedData = $autorisationAbsence->validate();

                // Mettre à jour la prise de congé
                $autorisationAbsence->update($validatedData);

                // Retourner une réponse de succès avec la prise de congé mise à jour
                return response()->json([
                    'success' => true,
                    'message' => 'Prise de congé mise à jour avec succès.',
                ]);
            } catch (\Exception $e) {
                // Retourner une réponse d'erreur en cas d'exception
                return response()->json([
                    'success' => false,
                    'message' => 'Échec de la mise à jour de la prise de congé.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AutorisatonAbsenceRequest $autorisationAbsence)
    {
        if (Auth::user()->hasAnyRole(['Ressource Humaine', 'Super Admin'])) {
            try {
                // Supprimer la prise de congé
                $autorisationAbsence->delete();

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
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }
}