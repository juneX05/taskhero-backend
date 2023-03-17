<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'user_types';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name')->unique();
            $table->string('title')->unique();
            $table->string('color');
            $table->integer('user_id');
            $table->longText('description')->nullable();
            $table->string('table');
            $table->timestamps();
            $table->string('urid')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
};
