<?php

use App\Models\Answer;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Question\Question;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->integer('votes')->default(0);
            $table->boolean('is_accepted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }

    public function answerQuestion(Request $request, $questionId)
{
    $validatedData = $request->validate([
        'answer' => 'required|string',
    ]);

    $user = Auth::user();
    $question = Question::findOrFail($questionId);

    // Simpan jawaban
    $answer = new Answer();
    $answer->question_id = $question->id;
    $answer->user_id = $user->id;
    $answer->answer = $validatedData['answer'];
    $answer->is_correct = $this->checkAnswer($validatedData['answer']); // Misal ada fungsi untuk cek jawaban benar
    $answer->save();

    // Cek apakah jawaban benar
    if ($answer->is_correct) {
        // Tambah hitungan jawaban benar
        $user->increment('correct_answers_count');

        // Jika jawaban benar mencapai 5 dan belum ada bronze badge
        if ($user->correct_answers_count % 5 == 0) {
            $user->increment('bronze_badges');
        }
    }

    return redirect()->back()->with('status', 'Jawaban berhasil disimpan!');
}

private function checkAnswer($answer)
{
    // Logika untuk memeriksa apakah jawaban benar
    // Misalnya, ini tergantung pada pertanyaan dan kriteria penilaiannya.
    return true; // misal jawaban selalu benar (logika ini bisa disesuaikan)
}

}
