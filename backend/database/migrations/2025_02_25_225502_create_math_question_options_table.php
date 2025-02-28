<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('math_question_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('math_question_id');
            $table->string('option_text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();

            $table->foreign('math_question_id')
                  ->references('id')->on('math_questions')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('math_question_options');
    }
};
