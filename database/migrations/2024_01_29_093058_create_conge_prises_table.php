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
        Schema::create('conge_prises', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('personnel_id');
            $table->integer('annee');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('nombre_jour');
            $table->string('status')->default('stand by');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            // Clé étrangère vers la table "personnel"
            $table->foreign('personnel_id')->references('id')->on('personnels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conge_prises');
    }
};
