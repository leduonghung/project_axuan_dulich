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
        Schema::create('post_language', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('language_id');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->longText('content');
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->text('meta_description');
            $table->unsignedBigInteger('userCreated')->nullable();
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
        Schema::dropIfExists('post_language');
    }
};
