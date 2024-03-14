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
        Schema::create('conge_cumules', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('personnel_id');
            $table->year('annee')->nullable();
            $table->integer('jour_total')->nullable();
            $table->integer('jour_prise')->nullable();
            $table->integer('jour_reste')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Clé étrangère vers la table personnel, ajustez le nom de la clé en fonction de votre configuration
            $table->foreign('personnel_id')->references('id_personnel')->on('personnels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conge_cumules');
    }
};
