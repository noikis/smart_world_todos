<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('list_id')->constrained('lists')->onDelete('cascade');
            $table->foreignId('executor_user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_completed');
            $table->text('description')->nullable();
            $table->integer('urgency');
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
        Schema::dropIfExists('tasks');

        Schema::table('tasks', function($table) {
            $table->dropIndex(['list_Id']);
            $table->dropIndex(['executor_user_id']);
        });    }
}
