<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flight_ticket_id')->index();
            $table->foreign('flight_ticket_id')->references('id')->on('flight_tickets')->cascadeOnDelete();
            $table->unsignedBigInteger('booking_id')->index();
            $table->foreign('booking_id')->references('id')->on('bookings')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->dateTime('date');
            $table->dateTime('before');
            $table->dateTime('title');
            $table->dateTime('info');
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
        Schema::dropIfExists('reminders');
    }
}
