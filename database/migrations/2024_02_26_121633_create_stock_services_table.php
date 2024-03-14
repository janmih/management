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
        Schema::create('stock_services', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('service_id');
            $table->string('designation');
            $table->string('reference_article');
            $table->unsignedInteger('stock_initial');
            $table->unsignedInteger('entree')->nullable();
            $table->unsignedInteger('sortie')->nullable();
            $table->unsignedInteger('stock_final');
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
        Schema::dropIfExists('stock_services');
    }
};
