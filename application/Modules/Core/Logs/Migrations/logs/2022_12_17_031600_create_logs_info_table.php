<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'db_log';
    private $table = 'logs_info';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)
            ->create($this->table, function (Blueprint $table) {
                $table->bigInteger('id')->primary();
                $table->string('request_id');
                $table->string('actor'); //Project_Model
                $table->integer('actor_id')->nullable(); //Record id
                $table->string('action_type');// UPDATED, CREATED, DELETED, VIEWED, LOG
                $table->string('action_name'); //CREATE PROJECT
                $table->longText('action_description')->nullable(); //Project ... created
                $table->longText('old_data')->nullable(); //{} json data for previous record
                $table->longText('new_data'); //{} json data for new record
                $table->string('urid');
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
        Schema::connection($this->connection)->dropIfExists($this->table);
    }
};
