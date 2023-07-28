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
        Schema::create('pack', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('created_by');
            $table->string('intitule', 30);
            $table->text('description');
            $table->bigInteger('prix');
            $table->integer('pourcentage');
            $table->integer('pourcentageReduction');//pourcentage de reduction apres une nouvelle generation
            $table->string('dateCreation', 15);
            $table->text('description_globale');
            $table->longText('imgUrl');
            $table->foreign('created_by')->references('id')->on('admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pack');
    }
};
