<?php


namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Service;
use App\Models\EtatStock;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Imports\ArticleImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\ImportFileRequest;
use Illuminate\Auth\Access\AuthorizationException;

class ArticleController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Vérifie si la requête est une requête AJAX
        if ($request->ajax()) {
            // Récupère tous les services depuis la base de données
            if (Auth::user()->hasAnyRole('Depositaire Comptable', 'Super Admin')) {
                $article = Article::with('service');
            } else {
                $article = Article::with('service')->where('service_id', auth()->user()->service_id);
            }

            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($article->get())
                ->addColumn('service_id', function ($row) {
                    return $row->service->nom;
                })
                ->addColumn('actions', function ($row) {
                    if (Auth::user()->hasAnyRole('Depositaire Comptable', 'Super Admin')) {
                        $btnEditer = '<button class="btn btn-warning btn-sm mb-3" onclick="openArticleModal(\'edit\', ' . $row->id . ')" title="Éditer"><i class="fas fa-pencil"></i></button>';
                        $btnSupprimer = '<button class="btn btn-danger btn-sm mb-3" onclick="deleteArticle(' . $row->id . ')" title="Supprimer"><i class="fas fa-trash"></i></button>';
                        return $btnEditer . ' ' . $btnSupprimer;
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        $routeName = Route::currentRouteName();
        // Extraire le segment principal du nom de la route
        $segments = explode('.', $routeName);
        $mainSegment = $segments[0];
        $services = Service::all();
        // Si ce n'est pas une requête AJAX, renvoie la vue pour l'affichage normal
        return view('articles.index', compact('mainSegment', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        if (Auth::user()->hasAnyRole('Depositaire Comptable', 'Super Admin')) {
            try {
                // Créer une nouvelle entrée dans la base de données avec les données validées du formulaire
                $article = Article::create($request->validated());

                // Vérifier si l'article existe dans la table etat_stocks
                $etatStock = EtatStock::where('article_id', $article->id)->first();

                if ($etatStock) {
                    // Si l'article existe, mettez à jour l'entrée
                    $etatStock->update([
                        'entree' => $request->entree + $etatStock->entree,
                        'stock_final' => $etatStock->stock_final + $request->entree
                    ]);
                } else {
                    // Si l'article n'existe pas, ajoutez une nouvelle ligne
                    EtatStock::create([
                        'article_id' => $article->id,
                        'entree' => $request->entree,
                        'sortie' => 0,
                        'stock_final' => $request->entree
                    ]);
                }

                // Retourner une réponse JSON avec un message de succès pour le traitement du formulaire
                return response()->json(['message' => 'Enregistrement réussi'], 200);
            } catch (\Exception $e) {
                // Retourner une réponse JSON avec un message d'erreur en cas d'échec de la création dans la base de données
                return response()->json(['error' => 'Une erreur est survenue lors du Enregistrement. Veuillez réessayer.'], 500);
            }
        } else {
            throw new AuthorizationException('You are not authorized to access this resource.');
        }
    }

    public function importArticle(ImportFileRequest $request)
    {
        if (Auth::user()->hasAnyRole('Depositaire Comptable', 'Super Admin')) {
            if ($request->hasFile('file')) {
                // Récupérer le fichier téléchargé
                $file = $request->file('file');
                // Obtenir l'extension du fichier
                $extension = $file->getClientOriginalExtension();
                // Vérifier si le fichier est un fichier Excel ou CSV
                if ($extension === 'xlsx' || $extension === 'xls' || $extension === 'csv') {
                    try {
                        // Utiliser Maatwebsite\Excel pour importer les données du fichier
                        $import = new ArticleImport();
                        Excel::import($import, $file);

                        // Retourner une réponse JSON avec un message de succès
                        return response()->json(['message' => 'Importation réussie', 'import' => $import], 200);
                    } catch (\Exception $e) {
                        // Retourner une réponse JSON avec un message d'erreur en cas d'échec de l'importation
                        return response()->json(['error' => 'Une erreur est survenue lors de l\'importation. Veuillez réessayer.', 'message' => $e->getMessage()], 500);
                    }
                } else {
                    // Retourner une réponse JSON avec un message d'erreur si le type de fichier n'est pas pris en charge
                    return response()->json(['error' => 'Type de fichier non pris en charge. Veuillez télécharger un fichier XLSX, XLS ou CSV.'], 400);
                }
            }
        } else {
            throw new AuthorizationException('You are not authorized to access this resource.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @return Article $article
     */
    public function edit(Article $article)
    {
        if (Auth::user()->hasAnyRole('Depositaire Comptable', 'Super Admin')) {
            return response()->json($article);
        } else {
            throw new AuthorizationException('You are not authorized to access this resource.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        if (Auth::user()->hasAnyRole('Depositaire Comptable', 'Super Admin')) {

            // Traiter le formulaire comme d'habitude
            try {
                // Met à jour le stock service avec les données du formulaire validées
                $article->update($request->validated());

                // Vérifier si l'article existe dans la table etat_stocks
                $etatStock = EtatStock::where('article_id', $article->id)->first();

                if ($etatStock) {
                    // Si l'article existe, mettez à jour l'entrée
                    $etatStock->update([
                        'entree' => $request->entree + $etatStock->entree,
                        'stock_final' => $etatStock->stock_final + $request->entree
                    ]);
                } else {
                    // Si l'article n'existe pas, ajoutez une nouvelle ligne
                    EtatStock::create([
                        'article_id' => $article->id,
                        'entree' => $request->entree,
                        'sortie' => 0,
                        'stock_final' => $request->entree
                    ]);
                }

                // Renvoie une réponse JSON indiquant le succès avec le code de statut 200 (OK)
                return response()->json(['success' => true, 'message' => 'Mis à jour avec succès'], Response::HTTP_OK);
            } catch (\Exception $e) {
                // En cas d'erreur, renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
                return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            throw new AuthorizationException('You are not authorized to access this resource.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if (Auth::user()->hasAnyRole('Depositaire Comptable', 'Super Admin')) {
            $article->delete();
            return response()->json(['success' => true, 'message' => "Supprimer avec success"]);
        } else {
            throw new AuthorizationException('You are not authorized to access this resource.');
        }
    }
}
