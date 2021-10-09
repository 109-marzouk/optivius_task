<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->json('name')->nullable(false);

            $table->string('email')->unique()->default(NULL)->nullable(true);
            $table->string('phone')->unique()->default(NULL)->nullable(true);

            $table->string('password')->nullable(false);


            $table->timestamp('verified_email_at')->nullable();
            $table->timestamp('verified_phone_at')->nullable();

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
        Schema::dropIfExists('profiles');
    }
}
