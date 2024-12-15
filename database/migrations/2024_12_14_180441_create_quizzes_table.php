<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Title of the quiz
            $table->text('description')->nullable(); // Description of the quiz
            $table->enum('status', ['public', 'private'])->default('private'); // Visibility status
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade'); // Author of the quiz
            $table->json('content'); // JSON field for quiz questions
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
}