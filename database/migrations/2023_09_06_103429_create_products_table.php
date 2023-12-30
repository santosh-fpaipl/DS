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

        // $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // product 
        // $table->foreignId('product_option_id')->constrained('product_options')->onDelete('cascade'); // product color
        // $table->foreignId('product_range_id')->constrained('product_ranges')->onDelete('cascade'); // product size

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            //$table->string('slug');
            $table->string('sid')->unique();
            $table->integer('start_price')->nullable();
            $table->integer('end_price')->nullable();
            $table->integer('moq')->default(1);
            $table->string('hsncode');
            $table->float('gstrate')->default(0.05);
            $table->text('tags')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('sid')->unique();
            $table->foreignId('product_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ranges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->integer('mrp');
            $table->integer('price');
            $table->string('sid')->unique();
            $table->boolean('active')->default(0); // 1,0
            $table->foreignId('product_id')->constrained();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('sizes');
    }
};