<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Personnel;
use App\Models\ModelHasRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\StoreModelHasRoleRequest;
use App\Http\Requests\UpdateModelHasRoleRequest;

class ModelHasRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::all();

            return datatables()->of($users)
                ->addColumn('roles', function ($user) {
                    return $user->roles()->pluck('name')->implode(' - ');
                })
                ->make(true);
        }
        $routeName = Route::currentRouteName();
        // Extraire le segment principal du nom de la route
        $segments = explode('.', $routeName);
        $mainSegment = $segments[0];
        $personnels = Personnel::all();
        $roles = Role::all();
        // Si ce n'est pas une requête AJAX, renvoie la vue pour l'affichage normal

        return view('model-has-roles.index', compact('mainSegment', 'personnels', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreModelHasRoleRequest $request)
    {
        return response()->json($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(ModelHasRole $modelHasRole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModelHasRole $modelHasRole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModelHasRoleRequest $request, ModelHasRole $modelHasRole)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelHasRole $modelHasRole)
    {
        //
    }
}
