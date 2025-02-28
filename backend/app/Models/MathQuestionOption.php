<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MathQuestionOption extends Model
{
    protected $fillable = ['math_question_id', 'option_text', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(MathQuestion::class);
    }
}