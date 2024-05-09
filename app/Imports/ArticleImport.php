<?php

namespace App\Imports;

use App\Models\Article;
use App\Models\EtatStock;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ArticleImport implements ToCollection, WithHeadingRow
{

    /**
     * Perform a collection operation on the provided data.
     *
     * @param Collection $collection The collection of data to process
     * @throws Some_Exception_Class Description of exception if any
     * @return Some_Return_Value Description of the return value if any
     */
    public function collection(Collection $collection)
    {

        foreach ($collection as $row) {
            // Créer un nouvel élément s'il n'existe pas déjà
            $article = Article::create([
                "service_id" => $row['service_id'],
                "reference_mouvement" => $row['reference_mouvement'],
                "compte_PCOP" => $row["category"],
                "reference" => $row['reference'],
                "designation" => $row['designation'],
                "conditionnement" => $row['conditionnement'],
                "unite" => $row['unite'],
                "date_peremption" => $row['date_peremption'],
                "provenance" => $row['provenance'],
                "entree" => $row['entree'],
                "etat_article" => $row['etat_article'],
            ]);
            // Vérifier si l'article existe dans la table etat_stocks
            $etatStock = EtatStock::whereHas('article', function ($query) use ($row) {
                $query->where('reference', $row['reference']);
            })->first();
            if ($etatStock != null) {
                // Si l'article existe, mettez à jour l'entrée
                $etatStock->update([
                    'entree' => $row['entree'] + $etatStock->entree,
                    'stock_final' => $row['entree'] + $etatStock->stock_final
                ]);
            } else {
                // Si l'article n'existe pas, ajoutez une nouvelle ligne
                EtatStock::create([
                    'article_id' => $article->id,
                    'entree' => $row['entree'],
                    'sortie' => 0,
                    'stock_final' => $row['entree']
                ]);
            }
        }
    }
}
