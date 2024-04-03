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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_catalogue_id');
            $table->foreign('post_catalogue_id')->references('id')->on('post_catalogues')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->text('icon')->nullable();
            $table->text('album')->nullable();
            $table->tinyInteger('public')->default(1);
            $table->float('order')->default(0);
            $table->unsignedBigInteger('userCreated');
            $table->foreign('userCreated')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('userUpdated')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
