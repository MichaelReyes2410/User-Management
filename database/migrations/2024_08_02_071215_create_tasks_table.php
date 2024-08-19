<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['todo', 'in-progress', 'done'])->default('todo');
            $table->enum('priority', ['high', 'medium', 'low'])->default('medium');
            $table->date('due_date')->nullable();
            $table->boolean('archived')->default(false);
            $table->timestamps();
        });

        Schema::create('task_prerequisites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->foreignId('prerequisite_task_id')->constrained('tasks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_prerequisites');
        Schema::dropIfExists('tasks');
    }
}
