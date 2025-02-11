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
        Schema::create('user_stats', function (Blueprint $table) {
            $table->foreignUuid('user_id')
            ->primary()
            ->constrained('users')
            ->cascadeOnDelete();
            $table->unsignedInteger('posts_count')->default(0);
            $table->unsignedInteger('following_count')->default(0);
            $table->unsignedInteger('followers_count')->default(0);
            $table->unsignedInteger('reels_count')->default(0);

            $table->index(['posts_count', 'following_count', 'followers_count', 'reels_count']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_stats');
    }
};
