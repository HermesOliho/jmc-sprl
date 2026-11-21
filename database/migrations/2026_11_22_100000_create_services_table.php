<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('icon', 50)->default('building2');
            $table->json('deliverables')->nullable();
            $table->json('benefits')->nullable();
            $table->boolean('is_featured')->default(false)->index();
            $table->unsignedInteger('home_sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->string('image_alt')->nullable();
            $table->string('image_position', 20)->default('center');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
