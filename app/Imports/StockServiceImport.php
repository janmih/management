<?php

namespace App\Imports;

use App\Models\StockService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StockServiceImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            // Rechercher un élément avec le même reference_article
            // $existingService = StockService::where('reference_article', $row['reference_article'])->first();
            $existingService = StockService::where('reference_article', $row['reference_article'])
                ->where('service_id', $row['service_id'])
                ->first();
            if ($existingService) {
                // Concaténer les nouvelles valeurs avec les valeurs existantes
                $existingService->update([
                    'designation' => $existingService->designation,
                    'stock_initial' => $existingService->stock_initial  +  $row['stock_initial'],
                    'entree' => $existingService->entree  +  $row['entree'],
                    'sortie' => $existingService->sortie  +  $row['sortie'],
                    'stock_final' => $existingService->stock_final  +  $row['stock_final'],
                    // Ajoutez d'autres colonnes au besoin
                ]);
            } else {
                // Créer un nouvel élément s'il n'existe pas déjà
                StockService::create([
                    'service_id' => $row['service_id'],
                    'designation' => $row['designation'],
                    'reference_article' => $row['reference_article'],
                    'stock_initial' => $row['stock_initial'],
                    'entree' => $row['entree'],
                    'sortie' => $row['sortie'],
                    'stock_final' => $row['stock_final'],
                    // Ajoutez d'autres colonnes au besoin
                ]);
            }
        }
    }
}
