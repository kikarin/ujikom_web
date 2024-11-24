<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendasTable extends Migration
{
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('event_date')->nullable(); // Membuat kolom ini nullable
            $table->timestamps();
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('agendas');
    }
}
