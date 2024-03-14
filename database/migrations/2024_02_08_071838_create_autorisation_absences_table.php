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
        Schema::create('autorisation_absences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personnel_id');
            $table->foreign('personnel_id')->references('id_personnel')->on('personnels');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('jour_prise');
            $table->integer('jour_reste');
            $table->string('motif')->nullable();
            $table->string('observation')->nullable();
            $table->string('status')->default('stand by');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autorisation_absences');
    }
};
