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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID');
            $table->string('content');
            $table->unsignedBigInteger('productID')->nullable();
            $table->unsignedBigInteger('oderID')->nullable();
            $table->unsignedBigInteger('notiLevel');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->foreign('userID')->references('id')->on('users')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('notiLevel')->references('id')->on('notiLevel')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('oderID')->references('id')->on('oders');
            $table->foreign('productID')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
