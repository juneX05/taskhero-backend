<?php

use Application\ApplicationBootstrapper;
use Application\Modules\System\Tasks\_Modules\Tags\Tags;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = Tags::TABLE;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $columns = Tags::COLUMNS;
        Schema::create($this->table, function (Blueprint $table) use ($columns) {

            foreach ($columns as $column) {
               ApplicationBootstrapper::processMigrationColumns($table, $column);
            }

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
