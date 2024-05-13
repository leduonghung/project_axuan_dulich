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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_catalogue_id')->comment('Nhom thanh vien ')->default(2);
            $table->string('name');
            $table->boolean('publish')->default(1);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone',20)->nullable();
            $table->string('province_id',10)->comment('Ma TP')->nullable();
            $table->string('district_id',10)->comment('Ma Quan')->nullable();
            $table->string('ward_id',10)->comment('Ma Phuong')->nullable();
            $table->string('address')->comment('Ma Phuong')->nullable();
            $table->date('birthday')->comment('')->nullable();
            $table->string('image')->nullable()->comment('');
            $table->text('description')->nullable();
            $table->text('user_agent')->nullable()->nullable();
            $table->string('ip',20)->nullable()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->integer('userCreated');
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
        Schema::dropIfExists('users');
    }
};
