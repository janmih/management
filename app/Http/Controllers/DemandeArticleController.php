<?php

namespace App\Http\Controllers;

use App\Models\EtatStock;
use App\Models\Personnel;
use App\Mail\NotifyArticle;
use Illuminate\Http\Request;
use App\Jobs\NotifyArticleJob;
use App\Models\DemandeArticle;
use Illuminate\Support\Facades\DB;
use App\Jobs\ArticleNotificationJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\AjouterRequest;
use App\Mail\UsersArtcileNotifcation;
use Illuminate\Support\Facades\Route;
use App\Jobs\SendEmailNotificationJob;
use App\Jobs\SendMailAfterValidateArticle;
use App\Mail\ArticleNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DepositaireNotification;
use Illuminate\Auth\Access\AuthorizationException;

class DemandeArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Vérifie si la requête est une requête AJAX
        if ($request->ajax()) {
            // Récupère tous les services depuis la base de données
            if (Auth::user()->hasAnyRole(['Depositaire Comptable', 'Super Admin'])) {
                $stock = EtatStock::with('article');
            } else {
                $stock = EtatStock::join('articles', 'etat_stocks.article_id', '=', 'articles.id')
                    ->where('articles.service_id', Auth::user()->service_id)
                    ->select('etat_stocks.*')
                    ->with('article')
                    ->get();
            }
            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($stock)
                ->addColumn('article_id', function ($row) {
                    return optional($row->article)->designation ?? '';
                })
                ->addColumn('quantity', function ($row) {
                    return '<input type="number" name="quantity" class="form-control" id="quantity_' . $row->article_id . '">';
                })
                ->addColumn('actions', function ($row) {
                    return '<button class="btn btn-success btn-sm" onclick="commander(' . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ')"><i class="fas fa-circle-check"></i></button>';
                })
                ->rawColumns(['actions', 'quantity'])
                ->make(true);
        }

        $routeName = Route::currentRouteName();
        // Extraire le segment principal du nom de la route
        $segments = explode('.', $routeName);
        $mainSegment = $segments[0];
        $personnel = Personnel::where('user_id', auth()->id())->first();
        $personnel_id = $personnel->id;
        // Si ce n'est pas une requête AJAX, renvoie la vue pour l'affichage normal
        return view('demande-articles.index', compact('mainSegment', 'personnel_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AjouterRequest $request The HTTP request
     * @throws Some_Exception_Class If the article is not found
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajouter(AjouterRequest $request)
    {
        $validatedData = $request->validated();
        DemandeArticle::create([
            "personnel_id" => $validatedData['personnel_id'],
            "article_id" => $validatedData['article_id'],
            "quantity" => $validatedData['quantity']
        ]);
        $etatStock = EtatStock::where('article_id', $validatedData['article_id'])->first();
        if ($etatStock) {
            $etatStock->update([
                'sortie' => $validatedData['quantity'],
                'stock_final' => $etatStock->stock_final - $validatedData['quantity']
            ]);
        } else {
            return response()->json(['success' => true, "message" => "L'article est introuvable"]);
        }
        return response()->json(['success' => true, "message" => "Article ajouter"]);
    }

    /**
     * Retrieves all services from the database and formats the data using DataTables for client response.
     *
     * @param Request $request The HTTP request
     * @throws Some_Exception_Class If authorization fails
     * @return View The view for normal display or JSON response for AJAX request
     */
    public function listeBons(Request $request)
    {
        if ($request->ajax()) {
            // Récupère tous les services depuis la base de données
            if (Auth::user()->hasRole('Super Admin')) {
                $personnels = Personnel::select('personnels.*')
                    ->leftJoin('users', 'personnels.user_id', '=', 'users.id')
                    ->leftJoin('services', 'personnels.service_id', '=', 'services.id')
                    ->whereIn('personnels.id', function ($query) {
                        $query->select('personnel_id')
                            ->from('demande_articles')
                            ->where('demande_articles.status', 'En attente');
                    })
                    ->whereNull('personnels.deleted_at')
                    ->get();
            } else {
                $personnels = Personnel::select('personnels.*')
                    ->leftJoin('users', 'personnels.user_id', '=', 'users.id')
                    ->leftJoin('services', 'personnels.service_id', '=', 'services.id')
                    ->whereIn('personnels.id', function ($query) {
                        $query->select('personnel_id')
                            ->from('demande_articles')
                            ->where('demande_articles.status', 'En attente');
                    })
                    ->where('services.id', auth()->user()->service_id)
                    ->whereNull('personnels.deleted_at')
                    ->get();
            }
            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($personnels)
                ->addColumn('personnel', function ($row) {
                    return $row->nom . ' ' . $row->prenom;
                })
                ->addColumn('actions', function ($row) {
                    return '<button class="btn btn-default btn-sm bg-info" onclick="voir(' . $row->id . ')"><i class="fas fa-eye"></i></button>';
                })
                ->rawColumns(['actions', 'quantity'])
                ->make(true);
        }

        $routeName = Route::currentRouteName();
        // Extraire le segment principal du nom de la route
        $segments = explode('.', $routeName);
        $mainSegment = $segments[0];
        // Si ce n'est pas une requête AJAX, renvoie la vue pour l'affichage normal
        return view('liste-bons.index', compact('mainSegment'));
    }

    public function listeArticleBons(Request $request, $id)
    {
        $personnel = Personnel::find($id);
        if (Auth::user()->id == $personnel->user_id || Auth::user()->hasAnyRole(['SSE', 'SPSS', 'SMF', 'Chefferie', 'Super Admin'])) {
            if ($request->ajax()) {
                // Récupère tous les services depuis la base de données
                $bons = DemandeArticle::with('article', 'article.etatStock')->where(['personnel_id' => $id, 'status' => 'En attente'])->get();
                // Utilise DataTables pour formater les données et les renvoyer au client
                return datatables()->of($bons)
                    ->addColumn('article', function ($row) {
                        return $row->article->designation;
                    })
                    ->addColumn('etatStock', function ($row) {
                        return $row->article->etatStock[0]->stock_final;
                    })
                    ->addColumn('actions', function ($row) {
                        if (Auth::user()->hasAnyRole(['SSE', 'SPSS', 'SMF', 'Chefferie', 'Super Admin'])) {
                            $btnValider =  '<button class="btn btn-success btn-sm" onclick="valider(' . $row->id . ')"><i class="fas fa-circle-check"></i></button>';
                            $btnRefuser =  '<button class="btn btn-danger btn-sm" onclick="refuser(' . $row->id . ')"><i class="fas fa-ban"></i></button>';
                            return $btnValider . ' ' . $btnRefuser;
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
            $personnel_id = $id;
            // Si ce n'est pas une requête AJAX, renvoie la vue pour l'affichage normal
            return view('liste-article-bons.index', compact('mainSegment', 'personnel_id'));
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function valide($id)
    {
        if (Auth::user()->hasAnyRole(['SSE', 'SPSS', 'SMF', 'Chefferie', 'Super Admin'])) {

            $demandeArticle = DemandeArticle::findOrFail($id);
            $demandeArticle->update(['status' => "Valider"]);
            return response()->json(['success' => true, "message" => "Demande valider", 'article' => $demandeArticle]);
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function refus($id)
    {
        if (Auth::user()->hasAnyRole(['SSE', 'SPSS', 'SMF', 'Chefferie', 'Super Admin'])) {

            $demande = DemandeArticle::findOrFail($id);
            DemandeArticle::findOrFail($id)->update(['status' => "Refuser"]);

            // Mettre à jour l'état de stock de l'article
            $etatStock = EtatStock::where('article_id', $demande->article_id)->first();
            if ($etatStock != null) {
                // Mettre à jour les valeurs d'état de stock en fonction de la demande refusée
                $etatStock->update([
                    'sortie' => $etatStock->sortie - $demande->quantity, // Soustraire la quantité de la demande refusée
                    'stock_final' => $etatStock->stock_final + $demande->quantity // Mettre à jour le stock final
                ]);
            }
            return response()->json(['success' => true, "message" => "Demande refuser"]);
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function notify(Request $request)
    {
        if (Auth::user()->hasAnyRole(['SSE', 'SPSS', 'SMF', 'Chefferie', 'Super Admin'])) {
            // Récupère l'id du demande dans l'url
            $segments = explode('/', $request->header('referer'));
            $personnel = Personnel::where('id', end($segments))->first();
            $materiels_valider = DemandeArticle::select('articles.designation', 'demande_articles.quantity')
                ->leftJoin('articles', 'demande_articles.article_id', '=', 'articles.id')
                ->where('personnel_id', end($segments))
                ->where('status', 'Valider')
                ->where('livrer', 'Non')
                ->get();
            $materiels_refuser = DemandeArticle::select('articles.designation', 'demande_articles.quantity')
                ->leftJoin('articles', 'demande_articles.article_id', '=', 'articles.id')
                ->where('personnel_id', end($segments))
                ->where('status', 'refuser')
                ->where('livrer', 'Non')
                ->get();
            ArticleNotificationJob::dispatch($personnel, $materiels_valider->toArray(), $materiels_refuser->toArray());
            return response()->json(['success' => true, "message" => "Notification envoyer"]);
        } else {
            throw new AuthorizationException('Vous n\'etes pas autorisé à accéder à cette ressource.');
        }
    }
}
