<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateStatusTable extends Migration {

    private $table = 'status';

    public function up(){
        Schema::create($this->table, function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name')->unique();
            $table->string('title')->unique();
            $table->string('color');
            $table->timestamps();
            $table->string('urid')->unique();
        });
    }

    public function down(){
        Schema::dropIfExists($this->table);
    }

}
