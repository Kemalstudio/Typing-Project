<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('typing_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('wpm');
            $table->unsignedDecimal('accuracy', 5, 2);
            $table->unsignedInteger('duration');
            $table->unsignedInteger('correct_chars');
            $table->unsignedInteger('total_chars');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('typing_results');
    }
};
