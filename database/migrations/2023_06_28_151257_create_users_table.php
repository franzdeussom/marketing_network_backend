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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_ID');
            $table->string('username', 35);
            $table->string('surname', 35);
            $table->string('email', 100)->unique();
            $table->string('tel', 9)->unique();
            $table->string('role', 30);
            $table->text('profilImgUrl')->nullable();
            $table->string('create_at', 15);
            $table->string('password', 30);
            $table->integer('tmp_parent_ID', false, true);
            $table->boolean('hasSuscribed');
            
            $table->integer('grandParent1_ID')->nullable();
            $table->integer('grandParent2_ID')->nullable();
            $table->foreign('parent_ID')->references('id')->on('users');            
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
