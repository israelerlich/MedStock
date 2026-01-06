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
        Schema::table('product_movements', function (Blueprint $table) {
            $table->integer('quantity')->after('type');
            $table->decimal('unit_price', 10, 2)->after('quantity');
            $table->decimal('total_price', 10, 2)->after('unit_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_movements', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'unit_price', 'total_price']);
        });
    }
};
