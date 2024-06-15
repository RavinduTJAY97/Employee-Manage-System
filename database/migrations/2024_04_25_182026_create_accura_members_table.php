<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccuraMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accura_members', function (Blueprint $table) {
            $table->id();
            $table->string('fname'); // First name
            $table->string('lname'); // Last name
            $table->date('d_o_b'); // Date of birth
            $table->longText('summary');
            $table->unsignedBigInteger('ds_division_id');
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
        Schema::dropIfExists('accura_members');
    }
}
