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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('level', ['primary', 'middle', 'secondary']);
            $table->string('mod_name');
            $table->string('email')->unique();
            $table->char('country', 2)->default('SA');
            $table->string('city')->nullable();
            $table->string('accreditation_number');
            $table->string('id_number', 50)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('users', function(Blueprint $table) {
            $table->foreignIdFor(App\Models\School::class)->nullable()->after('id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');

        Schema::table('users', function(Blueprint $table) {
            $table->dropForeign('school_id');
            $table->dropColumn('school_id');
        });
    }
};
