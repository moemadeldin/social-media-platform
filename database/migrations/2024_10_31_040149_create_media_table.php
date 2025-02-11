<?php

declare(strict_types=1);

use App\Enums\MediaType;
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
        Schema::create('media', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('post_id')
            ->constrained('posts')
            ->cascadeOnDelete();
            $table->uuidMorphs('mediable');
            $table->string('path');
            $table->enum('type', [MediaType::IMAGE->value, MediaType::VIDEO->value]);
            $table->unsignedInteger('order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
