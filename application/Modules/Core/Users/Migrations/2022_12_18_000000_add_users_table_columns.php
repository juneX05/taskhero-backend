<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersTableColumns extends Migration
{
    private $table = 'users';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->integer('user_status_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('user_type_id')->nullable();
            $table->string('urid')->unique()->nullable();
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->integer('user_status_id')->nullable(false)->change();
            $table->integer('user_id')->nullable(false)->change();
            $table->integer('user_type_id')->nullable(false)->change();
            $table->string('urid')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('users');
    }
}
