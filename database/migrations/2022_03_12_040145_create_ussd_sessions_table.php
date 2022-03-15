<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUssdSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ussd_sessions', function (Blueprint $table) {
            $table->id();
            $table->text('session_id');
            $table->text('phone_number');
            $table->text('current_screen');
            $table->text('previous_screen');
            $table->text('next_screen');
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
        Schema::dropIfExists('ussd_sessions');
    }
}
