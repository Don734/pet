<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type');
            $table->text('description')->nullable();
            $table->json('characteristics')->nullable();
            $table->json('services')->nullable();
            $table->decimal('price')->nullable();
            $table->unsignedBigInteger('handbook_id')->nullable();
            $table->timestamps();

            $table->foreign('handbook_id')->references('id')->on('handbooks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
