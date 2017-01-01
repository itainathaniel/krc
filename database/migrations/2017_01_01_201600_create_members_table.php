<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('knesset_id')->unique();
            $table->unsignedInteger('party_id')->nullable();
            $table->boolean('active')->default(1);
            $table->string('image');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('first_name_english');
            $table->string('last_name_english');
            $table->string('gender');
            $table->date('birth_date');
            $table->boolean('present');

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
        Schema::dropIfExists('members');
    }
}
