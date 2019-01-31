<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('name');
            $table->string('description');
            $table->string('color');
            $table->timestamps();
        });
        Schema::create('tag_task', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->integer('tag_id')->unsigned();
            $table->integer('task_id')->unsigned();
            $table->unique(['task_id','tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('tag_task');

    }
}
