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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->string('parent_name')->nullable();
            $table->string('parent_email')->nullable();
            $table->string('level', 20)->nullable();
            $table->string('class', 20)->nullable();
            $table->char('division', 1)->nullable();;
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
        Schema::dropIfExists('student_profiles');
    }
};
