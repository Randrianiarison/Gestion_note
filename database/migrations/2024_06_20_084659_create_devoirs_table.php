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
        Schema::create('devoirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_prof');
            $table->unsignedBigInteger('id_cours');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->integer('semestre');
            $table->string('annee_scolaire');
            $table->timestamps();

            $table->foreign('id_prof')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_cours')->references('id')->on('cours')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devoirs');
    }
};
