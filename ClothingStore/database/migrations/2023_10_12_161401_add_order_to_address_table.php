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
        Schema::table('address', function (Blueprint $table) {
            //
            $table->foreignId('order_id')->constrained('order', 'id')->nullable();
            $table->foreignId('order_master_id')->constrained('order_master', 'id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('address', function (Blueprint $table) {
            $table->dropColumn('order_id');
            $table->dropColumn('order_master_id');
        });
    }
};
