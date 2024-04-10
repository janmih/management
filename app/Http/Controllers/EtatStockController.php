<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\EtatStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            if (Auth::user()->hasAnyRole('Depositaire Comptable', 'Super Admin')) {
                $etatStock = EtatStock::with('article');
            } else {
                $etatStock = EtatStock::with('article')->whereHas('article', function ($query) {
                    $query->where('service_id', Auth::user()->service_id);
                })->get();
            }


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
