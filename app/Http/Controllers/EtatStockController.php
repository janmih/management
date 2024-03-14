<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\EtatStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class EtatStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Vérifie si la requête est une requête AJAX
        if ($request->ajax()) {
            // Récupère tous les services depuis la base de données
            $etatStock = EtatStock::with('article');

            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($etatStock)
                ->addColumn('article', function ($row) {
                    return $row->article->designation;
                })
                ->make(true);
        }

        $routeName = Route::currentRouteName();
        // Extraire le segment principal du nom de la route
        $segments = explode('.', $routeName);
        $mainSegment = $segments[0];
        // Si ce n'est pas une requête AJAX, renvoie la vue pour l'affichage normal
        return view('etat-stocks.index', compact('mainSegment'));
    }
}
