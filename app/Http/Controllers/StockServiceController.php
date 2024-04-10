<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\StockService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Imports\StockServiceImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\ImportFileRequest;
use App\Http\Requests\StockServiceRequest;

class StockServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Vérifie si la requête est une requête AJAX
        if ($request->ajax()) {
            // Récupère tous les services depuis la base de données
            $stockService = StockService::with('service')->where('service_id', auth()->user()->service_id);

            // Utilise DataTables pour formater les données et les renvoyer au client
            return datatables()->of($stockService)
                ->addColumn('service_id', function ($row) {
                    return $row->service->nom;
                })
                ->addColumn('actions', function ($row) {
                    $btnEditer = '<button class="btn btn-warning btn-sm mb-3" onclick="openStockServiceModal(\'edit\', ' . $row->id_stock_service . ')">Éditer</button>';
                    $btnSupprimer = '<button class="btn btn-danger btn-sm mb-3" onclick="deleteStockService(' . $row->id_stock_service . ')">Supprimer</button>';
                    return $btnEditer . ' ' . $btnSupprimer;
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
        return view('stock-services.index', compact('mainSegment', 'services'));
    }

    /**
     * Traite les soumissions de formulaire pour importer un fichier ou traiter les données directement.
     *
     * @param  \App\Http\Requests\StockServiceRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StockServiceRequest $request)
    {

        try {
            // Créer une nouvelle entrée dans la base de données avec les données validées du formulaire
            StockService::create($request->validated());

            // Retourner une réponse JSON avec un message de succès pour le traitement du formulaire
            return response()->json(['message' => 'Traitement du formulaire réussi'], 200);
        } catch (\Exception $e) {
            // Retourner une réponse JSON avec un message d'erreur en cas d'échec de la création dans la base de données
            return response()->json(['error' => 'Une erreur est survenue lors du traitement du formulaire. Veuillez réessayer.'], 500);
        }
    }


    public function importFile(ImportFileRequest $request)
    {
        if ($request->hasFile('file')) {
            // Récupérer le fichier téléchargé
            $file = $request->file('file');

            // Obtenir l'extension du fichier
            $extension = $file->getClientOriginalExtension();
            // Vérifier si le fichier est un fichier Excel ou CSV
            if ($extension === 'xlsx' || $extension === 'xls' || $extension === 'csv') {
                try {
                    // Utiliser Maatwebsite\Excel pour importer les données du fichier
                    $import = new StockServiceImport();
                    Excel::import($import, $file);

                    // Retourner une réponse JSON avec un message de succès
                    return response()->json(['message' => 'Importation réussie'], 200);
                } catch (\Exception $e) {
                    // Retourner une réponse JSON avec un message d'erreur en cas d'échec de l'importation
                    return response()->json(['error' => 'Une erreur est survenue lors de l\'importation. Veuillez réessayer.', 'message' => $e->getMessage()], 500);
                }
            } else {
                // Retourner une réponse JSON avec un message d'erreur si le type de fichier n'est pas pris en charge
                return response()->json(['error' => 'Type de fichier non pris en charge. Veuillez télécharger un fichier XLSX, XLS ou CSV.'], 400);
            }
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockService $stockService)
    {
        // Renvoie les données du service au format JSON
        return response()->json($stockService);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StockServiceRequest  $request
     * @param  \App\Models\StockService  $stockService
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StockServiceRequest $request, StockService $stockService)
    {

        // Traiter le formulaire comme d'habitude
        try {
            // Met à jour le stock service avec les données du formulaire validées
            $stockService->update($request->validated());

            // Renvoie une réponse JSON indiquant le succès avec le code de statut 200 (OK)
            return response()->json(['success' => true, 'message' => 'Mis à jour avec succès'], Response::HTTP_OK);
        } catch (\Exception $e) {
            // En cas d'erreur, renvoie une réponse JSON indiquant l'échec avec le code de statut 500 (Internal Server Error)
            return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockService  $stockService
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(StockService $stockService)
    {
        $stockService->delete();
        return response()->json(['success' => true, 'message' => 'Supprimé avec succès']);
    }
}