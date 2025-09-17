<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('invoice_no');
            $table->string('customer_id')->constrained('customers')->onDelete('cascade');

            $table->string('sale_type')->nullable();
            $table->decimal('delivery_charge', 10, 2)->nullable();
            $table->string('order_status')->nullable();

            $table->decimal('estimated_amount', 10, 2)->default(0.00);
            $table->string('discount')->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->decimal('total_paid', 10, 2)->default(0.00);
            $table->decimal('total_due', 10, 2)->default(0.00);
            $table->decimal('due_pay', 10, 2)->default(0.00)->nullable();
            $table->string('due_date')->nullable();
            $table->string('return_amount', )->nullable();
            $table->decimal('change_amount', 10, 2)->default(0.00)->nullable();
            $table->string('previous_due', )->nullable();
            $table->decimal('pay_point', 10, 2)->default(0.00)->nullable();
            $table->decimal('inv_point', 10, 2)->default(0.00)->nullable();
            $table->decimal('total_point', 10, 2)->default(0.00)->nullable();
            $table->decimal('profit', 10, 2)->default(0.00);
            $table->string('note')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('list_status')->default(0);
            $table->tinyInteger('is_web')->default(0);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
