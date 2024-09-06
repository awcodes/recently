<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recent_entries', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(config('recently.user_model'));
            $table->text('url');
            $table->string('icon');
            $table->string('title');

            $table->timestamps();
        });
    }
};
