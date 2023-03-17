<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'menus';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('title')->unique();
            $table->string('icon')->default('fa-th');
            $table->string('link')->nullable();
            $table->integer('parent')->nullable();
            $table->string('type')->default('link');
            $table->integer('position')->nullable();
            $table->string('category')->default('app');
            $table->integer('auth')->nullable();
            $table->integer('sidebar_visibility')->default(0);
            $table->integer('navbar_visibility')->default(0);
            $table->string('file_link')->nullable();
            $table->string('permission_name')->nullable();
            $table->integer('status_id')->nullable()->default(1);
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
