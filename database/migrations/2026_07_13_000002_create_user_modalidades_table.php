<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_modalidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('modalidade');
            $table->timestamps();

            $table->unique(['user_id', 'modalidade']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_modalidades');
    }
};
