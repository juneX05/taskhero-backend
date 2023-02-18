<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifierQueuesTable extends Migration
{
    private $table = 'notifier_queues';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->string('sender_name');
            $table->string('sender');
            $table->string('recipient_name');
            $table->string('recipient');
            $table->longText('message');
            $table->string('subject');
            $table->integer('notifier_type_id');
            $table->integer('sent_status_id')->default(0);
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
}
