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
        Schema::create('game_member_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_member_id');
            $table->foreign('game_member_id')->references('id')->on('game_member')->onDelete('cascade');
            $table->index('game_member_id');
            $table->integer('score')->nullable();
            $table->timestamp('scored_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_member_scores');
    }
};
