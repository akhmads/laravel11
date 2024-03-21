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
        Schema::create('sales_invoice_detail', function (Blueprint $table) {
            $table->id();
            $table->uuid('sales_invoice_id')->index();
            $table->foreignId('item_id')->index();
            $table->integer('qty');
            $table->unsignedDecimal('price',12,2);
            $table->unsignedDecimal('subtotal',12,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoice_detail');
    }
};