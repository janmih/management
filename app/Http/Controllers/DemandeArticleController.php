<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\HeloMail;
use App\Models\EtatStock;
use App\Models\Personnel;
use Illuminate\Http\Request;
use App\Models\DemandeArticle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\AjouterRequest;
use Illuminate\Support\Facades\Route;

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
            $stock = EtatStock::with('article');
            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($stock)
                ->addColumn('article_id', function ($row) {
                    return optional($row->article)->designation;
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
        $personnel = $user = Personnel::where('user_id', auth()->id())->first();
        $personnel_id = $personnel->id;
        // Si ce n'est pas une requête AJAX, renvoie la vue pour l'affichage normal
        return view('demande-articles.index', compact('mainSegment', 'personnel_id'));
    }

    public function ajouter(AjouterRequest $request)
    {
        DemandeArticle::create([
            "personnel_id" => $request->id,
            "article_id" => $request->article_id,
            "quantity" => $request->quantity
        ]);
        $etatStock = EtatStock::where('article_id', $request->article_id)->first();
        if ($etatStock) {
            $etatStock->update([
                'sortie' => $request->quantity,
                'stock_final' => $etatStock->stock_final - $request->quantity
            ]);
        } else {
            return response()->json(['success' => true, "message" => "L'article est introuvable"]);
        }
        return response()->json(['success' => true, "message" => "Demande valider"]);
    }

    public function listeBons(Request $request)
    {
        if ($request->ajax()) {
            // Récupère tous les services depuis la base de données
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
            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($personnels)
                ->addColumn('personnel', function ($row) {
                    return $row->nom . ' ' . $row->prenom;
                })
                ->addColumn('actions', function ($row) {
                    return '<button class="btn btn-success btn-sm" onclick="voir(' . $row->id . ')"><i class="fas fa-circle-check"></i></button>';
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
                    $btnValider =  '<button class="btn btn-success btn-sm" onclick="valider(' . $row->id . ')"><i class="fas fa-circle-check"></i></button>';
                    $btnRefuser =  '<button class="btn btn-danger btn-sm" onclick="refuser(' . $row->id . ')"><i class="fas fa-ban"></i></button>';
                    return $btnValider . ' ' . $btnRefuser;
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
    }


    /**
     * Store a newly created resource in storage.
     */
    public function valide($id)
    {

        $demandeArticle = DemandeArticle::findOrFail($id);
        $demandeArticle->update(['status' => "Valider"]);
        return response()->json(['success' => true, "message" => "Demande valider", 'article' => $demandeArticle]);
    }

    /**
     * Display the specified resource.
     */
    public function refus($id)
    {
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
    }

    public function notify()
    {
        $listMaterielValider = DemandeArticle::where('status', 'Valider')
            ->whereHas('personnel', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->with('personnel', 'article', 'personnel.service')
            ->where('livrer', 'Non')
            ->get();
        // dd($listMaterielValider);
        Mail::to(['cacsu.mg@gmail.com'])
            ->send(new HeloMail($listMaterielValider, $listMaterielValider->count()));
        return response()->json(['success' => true, "message" => "Notification envoyer"]);
    }
}
