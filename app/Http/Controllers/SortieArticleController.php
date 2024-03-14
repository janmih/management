<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Personnel;
use Illuminate\Http\Request;
use App\Models\SortieArticle;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\SortieArticleRequest;
use App\Models\DemandeArticle;

class SortieArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Vérifie si la requête est une requête AJAX
        if ($request->ajax()) {
            // Récupère tous les services depuis la base de données
            $sortieArticle = SortieArticle::with('personnel', 'article');

            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($sortieArticle)
                ->addColumn('article_id', function ($row) {
                    return $row->article->designation;
                })
                ->addColumn('personnel_id', function ($row) {
                    return $row->service->nom . ' ' . $row->service->prenom;
                })
                ->addColumn('actions', function ($row) {
                    $btnEditer = '<button class="btn btn-warning btn-sm mb-3" onclick="openSorteArticleModal(\'edit\', ' . $row->id . ')"><i class="fas fa-pencil"></i></button>';
                    $btnSupprimer = '<button class="btn btn-danger btn-sm mb-3" onclick="deleteSortieArticle(' . $row->id . ')"><i class="fas fa-trash"></i></button>';
                    return $btnEditer . ' ' . $btnSupprimer;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $routeName = Route::currentRouteName();
        // Extraire le segment principal du nom de la route
        $segments = explode('.', $routeName);
        $mainSegment = $segments[0];
        $personnels = Personnel::all();
        $articles = Article::all();
        // Si ce n'est pas une requête AJAX, renvoie la vue pour l'affichage normal
        return view('sortie-articles.index', compact('mainSegment', 'articles', 'personnels'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(SortieArticleRequest $request)
    {
        try {
            // Créer une nouvelle entrée dans la base de données avec les données validées du formulaire
            $sortieArticle = SortieArticle::create($request->validated());

            DemandeArticle::create([
                'sortie_article_id' => $sortieArticle->id,
            ]);

            // Retourner une réponse JSON avec un message de succès pour le traitement du formulaire
            return response()->json(['message' => 'Enregistrement réussi'], 200);
        } catch (\Exception $e) {
            // Retourner une réponse JSON avec un message d'erreur en cas d'échec de la création dans la base de données
            return response()->json(['error' => 'Une erreur est survenue lors du Enregistrement. Veuillez réessayer.'], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SortieArticle $sortieArticle)
    {
        return response()->json($sortieArticle);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SortieArticleRequest $request, SortieArticle $sortieArticle)
    {
        try {
            $ifStandBy = DemandeArticle::where(['status' => 'En attente', 'id' => $sortieArticle->id])->first();

            if ($ifStandBy) {
                $sortieArticle->update($request->validated());
            }

            // Vérifier si l'article existe dans la table etat_stocks

            // Retourner une réponse JSON avec un message de succès pour le traitement du formulaire
            return response()->json(['message' => 'Enregistrement réussi'], 200);
        } catch (\Exception $e) {
            // Retourner une réponse JSON avec un message d'erreur en cas d'échec de la création dans la base de données
            return response()->json(['error' => 'Une erreur est survenue lors du Enregistrement. Veuillez réessayer.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SortieArticle $sortieArticle)
    {
        $ifStandBy = DemandeArticle::where(['status' => 'En attente', 'id' => $sortieArticle->id])->first();

        if ($ifStandBy) {
            $sortieArticle->delete();
        }
        return response()->json(['success' => true, 'message' => 'Suppression réussi']);
    }
}
