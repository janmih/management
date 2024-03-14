<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('etat_stocks', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('entree')->nullable();
            $table->unsignedBigInteger('sortie')->nullable();
            $table->unsignedBigInteger('stock_final')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('article_id')->references('id_article')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etat_stocks');
    }
};
