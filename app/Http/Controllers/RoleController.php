<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Access\AuthorizationException;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->hasRole('Super Admin')) {
            if ($request->ajax()) {
                // Récupère tous les services depuis la base de données
                $roles = Role::all();
                // Utilise DataTables pour formater les données et les renvoyer au client
                return datatables()->of($roles)->make(true);
            }

            $routeName = Route::currentRouteName();
            // Extraire le segment principal du nom de la route
            $segments = explode('.', $routeName);
            $mainSegment = $segments[0];
            // Si ce n'est pas une requête AJAX, renvoie la vue pour l'affichage normal
            return view('roles.index', compact('mainSegment'));
        } else {
            throw new AuthorizationException('You are not authorized to access this resource.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        if (Auth::user()->hasRole('Super Admin')) {

            try {
                // Créer une nouvelle entrée dans la base de données avec les données validées du formulaire
                Role::create($request->validated());
                // Retourner une réponse JSON avec un message de succès pour le traitement du formulaire
                return response()->json(['message' => 'Enregistrement réussi'], 200);
            } catch (\Exception $e) {
                // Retourner une réponse JSON avec un message d'erreur en cas d'échec de la création dans la base de données
                return response()->json(['message' => 'Une erreur est survenue lors du Enregistrement. Veuillez réessayer.'], 500);
            }
        } else {
            throw new AuthorizationException('You are not authorized to access this resource.');
        }
    }
}
