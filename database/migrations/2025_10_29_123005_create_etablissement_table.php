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
        Schema::create('etablissements', function (Blueprint $table) {
            $table -> id();
            $table -> text('nometat');
            $table -> text('ville') ->nullable();
            $table -> string('liensite') -> nullable();
            $table -> string('descriptetat');
            $table -> string('contact')->nullable();
            $table -> string('email') -> unique()->nullable();
            $table -> string('type');
            $table -> string('photo')->nullable();
            $table -> boolean('visible')->default(false);
            $table -> timestamps();
        });
    }

};
