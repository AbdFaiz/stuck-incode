<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke pengguna
    protected static function booted()
    {
        static::updated(function ($answer) {
            if ($answer->is_accepted) {
                $user = $answer->user;
                $acceptedAnswersCount = $user->accepted_answers_count;

                // Tambahkan bronze badge jika jawaban yang diterima lebih dari 5
                if ($acceptedAnswersCount >= 5 && $acceptedAnswersCount < 25 && $user->bronze_badges == 0) {
                    $user->bronze_badges = 1;
                }

                // Tambahkan silver badge jika jawaban yang diterima lebih dari 25
                if ($acceptedAnswersCount >= 25 && $acceptedAnswersCount < 50 && $user->silver_badges == 0) {
                    $user->silver_badges = 1;
                }

                // Tambahkan gold badge jika jawaban yang diterima lebih dari 50
                if ($acceptedAnswersCount >= 50 && $user->gold_badges == 0) {
                    $user->gold_badges = 1;
                }

                $user->save();
            }
        });
    }

    // Relasi jawaban dengan pengguna
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke pertanyaan
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
