<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MathQuestion;

class MathQuestionController extends Controller
{
    public function index()
    {
        \Log::info('Database Connection Details:', [
            'host' => config('database.connections.mysql.host'),
            'port' => config('database.connections.mysql.port'),
            'database' => config('database.connections.mysql.database'),
            'username' => config('database.connections.mysql.username'),
        ]);

        \Log::info('Environment Variables:', [
            'DB_HOST' => env('DB_HOST'),
            'DB_PORT' => env('DB_PORT'),
            'DB_DATABASE' => env('DB_DATABASE'),
            'DB_USERNAME' => env('DB_USERNAME'),
        ]);


        $questions = MathQuestion::with(['options' => function($query) {
            $query->inRandomOrder();
        }])->inRandomOrder()->limit(4)->get();
        
        return response()->json($questions);
    }
}