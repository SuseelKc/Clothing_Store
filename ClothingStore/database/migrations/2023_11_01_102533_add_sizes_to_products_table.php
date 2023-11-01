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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('small')->nullable();
            $table->integer('medium')->nullable();
            $table->integer('large')->nullable();
            $table->integer('xl')->nullable();
            $table->integer('xxl')->nullable();
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->dropColumn('small');
            $table->dropColumn('medium');
            $table->dropColumn('large');
            $table->dropColumn('xl');
            $table->dropColumn('xxl'); 

        });
    }
};
