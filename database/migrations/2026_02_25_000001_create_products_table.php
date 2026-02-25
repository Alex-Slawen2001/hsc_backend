<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('sku')->nullable()->index();
            $table->string('model')->nullable()->index();
            $table->string('category')->nullable()->index();
            $table->string('availability')->nullable();
            $table->unsignedBigInteger('price_rub')->default(0);
            $table->string('image_path')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
