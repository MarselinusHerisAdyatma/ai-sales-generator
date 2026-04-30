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
        Schema::create('sales_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->text('description');
            $table->text('features')->nullable();
            $table->string('target_audience')->nullable();
            
            // Kolom Harga & Mata Uang
            $table->string('price')->nullable(); 
            $table->string('currency')->default('USD'); // Otomatis berada di bawah price

            $table->text('unique_selling_points')->nullable();
            $table->longText('generated_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_pages');
    }
};