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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('product_variation_id')->nullable();
            $table->string('warranty')->nullable();
            $table->string('new_details')->nullable();
            $table->decimal('rate', 10, 2)->default(0.00);
            $table->decimal('main_qty')->default(0);
            $table->decimal('sub_qty')->default(0);
            $table->decimal('product_discount', 10, 2)->default(0);
            $table->decimal('product_discount_amount', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('inv_subtotal', 10, 2)->default(0.00);
            $table->decimal('pur_subtotal', 10, 2)->default(0.00);
            $table->decimal('rtn_main', 10, 2)->default(0.00);
            $table->decimal('rtn_sub', 10, 2)->default(0.00);
            $table->decimal('rtn_total', 10, 2)->default(0.00);
            $table->decimal('profit', 10, 2)->default(0.00);
            $table->string('is_return')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
