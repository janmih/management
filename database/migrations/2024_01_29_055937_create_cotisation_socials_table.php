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
        Schema::create('cotisation_socials', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('mission_id');
            $table->decimal('montant', 10, 2);
            $table->string('status')->default('non payé');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Ajout de la clé étrangère
            $table->foreign('mission_id')->references('id_mission')->on('missions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotisation_socials');
    }
};
