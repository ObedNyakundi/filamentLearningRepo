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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                    ->constrained(table: 'customers')
                    ->cascadeOnDelete();
            $table ->string('number')->unique();
            $table-> decimal('total_price',10,2);
            $table-> enum('status',['pending','processing','completed','declined']) ->default('pending');
            $table->decimal('shipping_price',10,2)->nullable();
            $table->longText('notes');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};