<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Models\Role as ModelsRole;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * This function handles the HTTP GET request to list all roles.
     * It checks if the authenticated user has the 'Super Admin' role.
     * If the request is an AJAX request, it retrieves all roles from the database
     * and uses DataTables to format the data and send it back to the client.
     * Otherwise, it extracts the main segment from the current route name,
     * and renders the 'roles.index' view with the main segment as a variable.
     *
     * @param Request $request The HTTP request
     * @throws AuthorizationException If the user is not authorized
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Check if the user has the 'Super Admin' role
        if (Auth::user()->hasRole(ModelsRole::find(1))) {
            // Check if the request is an AJAX request
            if ($request->ajax()) {
                // Retrieve all roles from the database
                $roles = Role::all();
                // Use DataTables to format the data and send it back to the client
                return datatables()->of($roles)->make(true);
            }

            // Extract the main segment from the current route name
            $routeName = Route::currentRouteName();
            $segments = explode('.', $routeName);
            $mainSegment = $segments[0];

            // Render the 'roles.index' view with the main segment as a variable
            return view('roles.index', compact('mainSegment'));
        }

        // Throw an exception if the user is not authorized
        throw new AuthorizationException('You are not authorized to access this resource.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * This function handles the HTTP POST request to store a new role.
     * It checks if the authenticated user has the 'Super Admin' role.
     * If the user has the role, it validates the request data and creates a new entry in the database.
     * It returns a JSON response with a success message for a successful form submission,
     * or an error message with a 500 status code in case of database creation failure.
     * If the user is not authorized, it throws an `AuthorizationException`.
     *
     * @param RoleStoreRequest $request The HTTP request containing the data for the new role
     * @throws AuthorizationException If the user is not authorized to access this resource
     * @return \Illuminate\Http\JsonResponse The JSON response with the appropriate message
     */
    public function store(RoleStoreRequest $request)
    {
        // Check if the user has the 'Super Admin' role
        if (Auth::user()->hasRole('Super Admin')) {

            try {
                // Validate the request data
                $validatedData = $request->validated();

                // Create a new entry in the database with the validated data
                Role::create($validatedData);

                // Return a JSON response with a success message
                return response()->json(['message' => 'Enregistrement réussi'], 200);
            } catch (\Exception $e) {
                // Return a JSON response with an error message in case of database creation failure
                return response()->json([
                    'message' => 'Une erreur est survenue lors du Enregistrement. Veuillez réessayer.',
                ], 500);
            }
        }

        // Throw an exception if the user is not authorized
        throw new AuthorizationException('You are not authorized to access this resource.');
    }
}
