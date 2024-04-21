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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("category_id")->constrained("categories");
            $table->foreignId("province_id")->constrained("provinces");
            $table->foreignId("city_id")->constrained("cities");
            $table->string("title");
            $table->text("slug")->nullable();
            $table->text("description");
            $table->text("service_image_path")->nullable();
            $table->integer("work_experience_duration")->nullable();
            $table->enum("work_experience_unit", ["month", "year"])->nullable();
            $table->enum("status", ["active", "deactive"])->default("deactive");
            $table->text("links")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
