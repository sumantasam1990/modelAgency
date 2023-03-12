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
        Schema::table('users', function (Blueprint $table) {
            $table->string('age')->index();
            $table->integer('bust')->index()->nullable();
            $table->string('eyes')->index()->nullable();
            $table->integer('hips')->index()->nullable();
            $table->string('skin')->index()->nullable();
            $table->string('dress')->index()->nullable();
            $table->string('other')->index()->nullable();
            $table->integer('waist')->index()->nullable();
            $table->float('height')->index()->nullable();
            $table->string('hair')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
