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
        Schema::create('radios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->references('id')->on('semesters')->cascadeOnDelete();
            $table->enum('level', ['primary', 'middle', 'secondary']);
            $table->string('subject')->nullable();
            $table->string('attachment')->nullable();
            $table->unsignedTinyInteger('week_number');
            $table->date('radio_date');
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
        Schema::dropIfExists('radios');
    }
};
