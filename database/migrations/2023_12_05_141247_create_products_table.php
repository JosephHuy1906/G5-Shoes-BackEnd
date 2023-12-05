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
            $table->string("name");
            $table->unsignedBigInteger("categoryID");
            $table->unsignedBigInteger("sizeID");
            $table->string("img1");
            $table->string("img2");
            $table->string("img3");
            $table->string("img4");
            $table->integer("newPrice");
            $table->string("description", length: 10000);
            $table->integer("oldPrice");
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->foreign('categoryID')->references('id')->on('categorys')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('sizeID')->references('id')->on('size')
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
        Schema::dropIfExists('products');
    }
};
