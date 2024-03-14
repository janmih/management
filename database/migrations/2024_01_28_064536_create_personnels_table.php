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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_id')->after('id_personnel')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('service_id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('cin', 12)->unique();
            $table->date('date_cin');
            $table->string('com_cin');
            $table->string('duplicata');
            $table->date('date_duplicata');
            $table->date('ddn');
            $table->integer('age');
            $table->string('genre');
            $table->text('adresse');
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->string('photo')->nullable();
            $table->string('fonction');
            $table->integer('matricule');
            $table->integer('indice');
            $table->string('corps');
            $table->string('grade');
            $table->date('date_effet_avancement')->nullable();
            $table->date('fin_date_effet_avancement')->nullable();
            $table->string('classe');
            $table->string('echelon');

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
        Schema::dropIfExists('personnels');
    }
};
