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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->text("slug")->nullable();
            $table->text("profile_path")->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->string('email')->unique();
            $table->enum("gender", ["male", "female", "none"])->nullable();
            $table->enum("status", ["active", "ban"])->default("active");
            $table->timestamp("account_verified_at")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
