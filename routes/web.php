<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [PostController::class, 'topQuestions'])->name('home');

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class);
    Route::resource('tags', TagController::class);


    Route::get('/api/tags', function (Request $request) {
        $query = $request->get('query');
        $tags = Tag::where('name', 'like', "%{$query}%")->take(10)->get(); // Adjust limit as needed
        return response()->json($tags);
    });


    // jawaban dan fiturnya
    Route::post('/posts/{post}/vote', [PostController::class, 'vote'])->name('posts.vote');
    Route::post('/posts/{post}/downvote', [PostController::class, 'downvote'])->name('posts.downvote');

    Route::post('/answers/{answer}/vote', [AnswerController::class, 'vote'])->name('answers.vote');
    Route::post('/answers/{answer}/downvote', [AnswerController::class, 'downvote'])->name('answers.downvote');
    Route::get('/tags/{tag}', [TagController::class, 'show'])->name('tags.show');

    // users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/api/users', function (Request $request) {
        $query = $request->get('query');
        $users = User::where('name', 'like', "%{$query}%")->take(10)->get(); // Adjust limit as needed
        return response()->json($users);
    });
    Route::get('/profile/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/profile/{user}', [UserController::class, 'update'])->name('users.profile.update');
    
    // save posts from user
    Route::get('/saved-posts', [UserController::class, 'savedPosts'])->name('saved.posts');
    Route::post('/posts/{post}/save', [PostController::class, 'savePost'])->name('posts.save');
    Route::delete('/posts/{post}/unsave', [PostController::class, 'unsavePost'])->name('posts.unsave');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');


    // Route::post('/posts/{post}/answers/{answer}/mark-as-correct', [AnswerController::class, 'markAsAccepted'])->name('answers.markAsAccepted');
    // Route::post('/posts/{post}/answers', [AnswerController::class, 'store'])->name('answers.store');
});
