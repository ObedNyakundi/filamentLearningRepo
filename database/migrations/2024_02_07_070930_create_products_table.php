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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')
                    ->constrained(table: 'brands')
                    ->cascadeOnDelete();
            $table->string('name');
            $table->string('slug') ->unique();
            $table->string('image');
            $table->string('sku') ->unique();
            $table->text('description')->nullable();
            $table->unsignedbigInteger('quantity') -> default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('is_visible')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->enum('type', ['deliverable', 'downloadable'])->default('deliverable');
            $table->date('published_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
