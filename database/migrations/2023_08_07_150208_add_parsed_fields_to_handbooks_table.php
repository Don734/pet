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
        Schema::table('handbooks', function (Blueprint $table) {
            $table->string('outer_type')->nullable();
            $table->string('outer_id')->nullable();
            $table->text('outer_link')->nullable();
            $table->string('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('handbooks', function (Blueprint $table) {
            $table->dropColumn('outer_type');
            $table->dropColumn('outer_id');
            $table->dropColumn('outer_link');
            $table->dropColumn('price');
        });
    }
};
