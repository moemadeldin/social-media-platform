<?php

declare(strict_types=1);

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
        Schema::create('post_collaborator', function (Blueprint $table) {
            $table->foreignUuid('user_id')
                ->primary()
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignUuid('post_id')
                ->primary()
                ->constrained('posts')
                ->cascadeOnDelete();
            $table->unique(['post_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_collaborator');
    }
};
