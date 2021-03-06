<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRoot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_root', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
            $table->integer('user_id')->unsigned();           			
            $table->timestamps();
			
			$table->engine = 'InnoDB';
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_root');
    }
}
