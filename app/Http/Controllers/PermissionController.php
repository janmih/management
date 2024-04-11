<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\StorePermissionRequest;
use Illuminate\Auth\Access\AuthorizationException;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->hasRole('Super Admin')) {
            if ($request->ajax()) {
                // Récupère tous les services depuis la base de données
                $permissions = Permission::all();
                // Utilise DataTables pour formater les données et les renvoyer au client
                return datatables()->of($permissions)->make(true);
            }

            $routeName = Route::currentRouteName();
            // Extraire le segment principal du nom de la route
            $segments = explode('.', $routeName);
            $mainSegment = $segments[0];
            // Si ce n'est pas une requête AJAX, renvoie la vue pour l'affichage normal
            return view('permissions.index', compact('mainSegment'));
        } else {
            throw new AuthorizationException('You are not authorized to access this resource.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        if (Auth::user()->hasRole('Super Admin')) {

            try {
                // Créer une nouvelle entrée dans la base de données avec les données validées du formulaire
                Permission::create($request->validated());
                // Retourner une réponse JSON avec un message de succès pour le traitement du formulaire
                return response()->json(['message' => 'Enregistrement réussi'], 200);
            } catch (\Exception $e) {
                // Retourner une réponse JSON avec un message d'erreur en cas d'échec de la création dans la base de données
                return response()->json(['message' => 'Une erreur est survenue lors du Enregistrement. Veuillez réessayer.', 'error' => $e], 500);
            }
        } else {
            throw new AuthorizationException('You are not authorized to access this resource.');
        }
    }
}
