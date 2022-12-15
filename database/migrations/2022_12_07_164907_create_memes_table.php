<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemesTable extends Migration
{
    public function up()
    {
        Schema::create('memes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');;
            $table->string('title', 200);
            $table->text('body');
            $table->text('example');
            $table->string('type', 25);
            $table->string('city', 25);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('memes');
    }
}
