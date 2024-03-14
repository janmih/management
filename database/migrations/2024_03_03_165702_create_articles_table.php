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
        Schema::create('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('id_article');
            $table->unsignedBigInteger('service_id');
            $table->char('reference_mouvement', 100)->nullable();
            $table->integer('compte_PCOP')->nullable();
            $table->string('reference')->nullable();
            $table->text('designation')->nullable();
            $table->text('conditionnement')->nullable();
            $table->string('unite')->nullable();
            $table->date('date_peremption')->nullable();
            $table->char('provenance', 255)->nullable();
            $table->integer('entree')->nullable();
            $table->string('etat_article')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('service_id')->references('id_service')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
