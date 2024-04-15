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
        Schema::create('post_catalogue_language', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_catalogue_id');
            $table->unsignedBigInteger('language_id');
            // $table->foreign('post_catalogue_id')->references('id')->on('post_catalogues')->onDelete('cascade');
            // $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->longText('content');
            $table->string('meta_title');
            $table->string('canonical')->comment('duong dan')->unique();
            $table->string('meta_keyword');
            $table->text('meta_description');
            $table->unsignedBigInteger('userCreated');
            $table->foreign('userCreated')->references('id')->on('users')->onDelete('cascade');
            $table->integer('userUpdated')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_catalogue_language');
    }
};
