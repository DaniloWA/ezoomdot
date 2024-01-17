<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    //TODO! Adicionar equipes de tarefas
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('title', 150);
            $table->string('slug', 150)->index();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'completed', 'canceled'])
                ->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])
                ->default('low');
            $table->dateTime('deadline')
                ->default(now()->addDays(5))
                ->comment('The date and time by which the task should be completed. Default is 5 days from now.');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
}
