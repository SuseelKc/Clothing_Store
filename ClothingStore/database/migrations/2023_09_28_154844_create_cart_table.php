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
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products', 'id'); //
            $table->decimal('rate', 10, 2); //
            $table->string('color')->nullable();;
            $table->decimal('price', 10, 2)->nullable();
            
            $table->integer('quantity')->nullable();
            $table->foreignId('user_id')->constrained('users', 'id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
