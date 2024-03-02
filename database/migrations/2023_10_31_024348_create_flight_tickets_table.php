<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('pnr');
            $table->string('airline');
            $table->dateTime('departure_date');
            $table->dateTime('return_date');
            $table->string('from');
            $table->string('to');
            $table->string('seat');
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
        Schema::dropIfExists('flight_tickets');
    }
}
