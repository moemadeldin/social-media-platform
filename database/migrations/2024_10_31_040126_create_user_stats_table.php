<?php


declare(strict_types = 1);

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
        Schema::create('user_stats', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
            ->nullable()
            ->constrained('users')
            ->cascadeOnDelete();
            $table->unsignedInteger('posts_count')
            ->default(0)
            ->index();
            $table->unsignedInteger('following_count')->default(0)
            ->index();
            $table->unsignedInteger('followers_count')->default(0)
            ->index();
            $table->unsignedInteger('reels_count')
            ->default(0)
            ->index();
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
