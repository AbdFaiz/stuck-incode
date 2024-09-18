<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class);
    Route::get('/questions', [App\Http\Controllers\HomeController::class, 'allQuest'])->name('questions');

    Route::get('/home', [App\Http\Controllers\PostController::class, 'topQuestions'])->name('home');

    Route::resource('posts', PostController::class);
    Route::resource('tags', TagController::class);
    Route::get('/questions', [App\Http\Controllers\PostController::class, 'index'])->name('questions');

Route::get('/api/tags', function (Request $request) {
    $query = $request->query('query');
    $tags = Tag::where('name', 'like', "%{$query}%")->limit(5)->get(['name']);
    return response()->json($tags);
});
});
