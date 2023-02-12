<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    protected $connection = 'db_log';
    private $table = 'logs';
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
                $table->string('request_url');
                $table->longText('request_data');
                $table->string('request_method');
                $table->string('request_content_type')->nullable();
                $table->longText('request_client_ips');
                $table->bigInteger('user_id')->nullable();
                $table->string('user');
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
}
