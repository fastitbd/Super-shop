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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->date('date')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('district')->nullable();
            $table->string('thana')->nullable();
            $table->string('unions')->nullable();
            $table->string('address')->nullable();
            $table->decimal('total_point',10,2)->default(0)->nullable();
            $table->decimal('open_receivable',10,2)->default(0)->nullable();
            $table->decimal('open_payable',10,2)->default(0)->nullable();
            $table->string('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
