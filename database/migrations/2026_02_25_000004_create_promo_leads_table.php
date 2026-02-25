<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('promo_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('model')->nullable();
            $table->longText('message')->nullable();

            $table->unsignedBigInteger('base_price')->default(0);
            $table->unsignedBigInteger('extra_price')->default(0);
            $table->unsignedTinyInteger('discount_percent')->default(15);
            $table->unsignedBigInteger('discount_amount')->default(0);
            $table->unsignedBigInteger('total_after_discount')->default(0);

            $table->string('ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_leads');
    }
};
