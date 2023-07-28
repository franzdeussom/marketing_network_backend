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
        Schema::create('souscription', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_pack');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_admin');
            $table->string('state', 30);
            $table->string('create_at', 15);
            $table->string('approuved_at', 15)->nullable();
            
            $table->foreign('id_admin')->references('id')->on('admin');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_pack')->references('id')->on('pack');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('souscription');
    }
};
