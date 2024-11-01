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
        Schema::create('messages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('group_id')
            ->nullable()
            ->constrained('groups')
            ->cascadeOnDelete();
            $table->foreignUuid('conversation_id')
            ->nullable()
            ->constrained('conversations')
            ->cascadeOnDelete();
            $table->foreignUuid('sender_id')
            ->nullable()
            ->constrained('users')
            ->cascadeOnDelete();
            $table->foreignUuid('receiver_id')
            ->nullable()
            ->constrained('users')
            ->cascadeOnDelete();
            $table->text('message')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
