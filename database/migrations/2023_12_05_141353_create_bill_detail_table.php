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
        Schema::create('bill_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('billID');
            $table->unsignedBigInteger('productID');
            $table->unsignedBigInteger('sizeID');
            $table->unsignedBigInteger('userID');
            $table->integer('price');
            $table->integer('quantity');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->foreign('billID')->references('id')->on('bill')->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('productID')->references('id')->on('products')->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('userID')->references('id')->on('users')->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('sizeID')->references('id')->on('size')->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_detail');
    }
};
