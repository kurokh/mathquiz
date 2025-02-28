<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MathQuestion extends Model
{
    protected $fillable = ['question'];

    public function options()
    {
        return $this->hasMany(MathQuestionOption::class);
    }
}