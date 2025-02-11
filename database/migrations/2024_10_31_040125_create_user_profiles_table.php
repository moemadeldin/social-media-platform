<?php


declare(strict_types = 1);

use App\Enums\Gender;
use App\Enums\ProfileStatus;
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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->foreignUuid('user_id')
            ->primary()
            ->constrained('users')
            ->cascadeOnDelete();
            $table->string('profile_picture')->nullable();
            $table->unsignedTinyInteger('gender')->default(Gender::PREFER_NOT_TO_SAY->value);
            $table->string('bio', 150)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('mobile')->nullable();
            $table->unsignedTinyInteger('profile_status')->default(ProfileStatus::PUBLIC->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
