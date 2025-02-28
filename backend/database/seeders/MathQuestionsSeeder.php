<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MathQuestionsSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // Question 1: Solve quadratic equation
        $questionId = DB::table('math_questions')->insertGetId([
            'question'   => 'Solve for x: 2x² - 8x + 6 = 0',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('math_question_options')->insert([
            [
                'math_question_id' => $questionId,
                'option_text'      => 'x = 1 and x = 3',
                'is_correct'       => true,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'math_question_id' => $questionId,
                'option_text'      => 'x = 2 and x = 3',
                'is_correct'       => false,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'math_question_id' => $questionId,
                'option_text'      => 'x = 1 and x = 2',
                'is_correct'       => false,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'math_question_id' => $questionId,
                'option_text'      => 'x = 0 and x = 4',
                'is_correct'       => false,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
        ]);

        // Question 2: Slope of the perpendicular line to a given line
        $questionId = DB::table('math_questions')->insertGetId([
            'question'   => 'Determine the slope of the line perpendicular to the line 3x - 4y = 12.',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('math_question_options')->insert([
            [
                'math_question_id' => $questionId,
                'option_text'      => '-4/3',
                'is_correct'       => true,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'math_question_id' => $questionId,
                'option_text'      => '4/3',
                'is_correct'       => false,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'math_question_id' => $questionId,
                'option_text'      => '-3/4',
                'is_correct'       => false,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'math_question_id' => $questionId,
                'option_text'      => '3/4',
                'is_correct'       => false,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
        ]);

        // Question 3: Area of a circle
        $questionId = DB::table('math_questions')->insertGetId([
            'question'   => 'What is the area of a circle with a radius of 5?',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('math_question_options')->insert([
            [
                'math_question_id' => $questionId,
                'option_text'      => '25π',
                'is_correct'       => true,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'math_question_id' => $questionId,
                'option_text'      => '10π',
                'is_correct'       => false,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'math_question_id' => $questionId,
                'option_text'      => '5π',
                'is_correct'       => false,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'math_question_id' => $questionId,
                'option_text'      => '50π',
                'is_correct'       => false,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
        ]);

        // Question 4: Equation of a line through two points
        $questionId = DB::table('math_questions')->insertGetId([
            'question'   => 'Find the equation of the line passing through the points (1,2) and (3,10).',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('math_question_options')->insert([
            [
                'math_question_id' => $questionId,
                'option_text'      => 'y = 4x - 2',
                'is_correct'       => true,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'math_question_id' => $questionId,
                'option_text'      => 'y = 4x + 2',
                'is_correct'       => false,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'math_question_id' => $questionId,
                'option_text'      => 'y = 2x - 4',
                'is_correct'       => false,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'math_question_id' => $questionId,
                'option_text'      => 'y = 2x + 4',
                'is_correct'       => false,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
        ]);
    }
}
