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
        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('productID');
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('notiLevelID');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->foreign('productID')->references('id')->on('products')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('userID')->references('id')->on('users')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('notiLevelID')->references('id')->on('level')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification');
    }
};