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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('winner_id')->nullable()->index('winner_id');
            $table->foreign('winner_id')->references('id')->on('members');
            $table->date('date');
            $table->integer('game_duration_in_minutes');
            $table->integer('total_score')->nullable();
            $table->enum('status',['completed','in-progress','not-started'])->default('not-started');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign(['winner_id']);
            $table->dropColumn('winner_id');
        });
    }
};
