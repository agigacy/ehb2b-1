<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('package_name');
            $table->string('package_name_chinese');
            $table->string('airline');
            $table->string('code');
            $table->dateTime('departure_date');
            $table->dateTime('return_date');
            $table->integer('sp')->nullable();
            $table->integer('tier1')->nullable();
            $table->integer('tier2')->nullable();
            $table->integer('tier3');
            $table->integer('sp_c')->nullable();
            $table->integer('tier1_c')->nullable();
            $table->integer('tier2_c')->nullable();
            $table->integer('tier3_c');
            $table->unsignedBigInteger('country_id')->index();
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
            $table->integer('min_g');
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours');
    }
}
