<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query) use ($search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%");
        })->withCount(['posts', 'answers']) // Menghitung posts dan answers
            ->paginate(36);

        if ($request->ajax()) {
            return response()->json($users);
        }

        return view('users.index', compact('users'));
    }


    public function savedPosts()
    {
        $savedPosts = Auth::user()->savedPosts;

        return view('saved', compact('savedPosts'));
    }

    public function show($id)
    {
        $user = User::with([
            'posts', // Ambil semua posts
            'answers' // Ambil semua answers
        ])
            ->withCount(['posts', 'answers']) // Hitung total posts dan answers
            ->findOrFail($id);

        $totalVotes = $user->posts->sum('votes') + $user->answers->sum('votes');
        $reached = $user->bronze_badges + $user->silver_badges + $user->gold_badges;

        // dd($user);

        return view('users.show', compact('user', 'totalVotes', 'reached'));
    }

    public function edit(User $user)
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Validasi input
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bio' => 'nullable|string|max:500',
        ]);

        // Update user data
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->image) {
                Storage::delete('public/' . $user->image);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('profile_pictures', 'public');
            $user->image = $imagePath;
        }

        $user->save();

        return redirect()->route('users.show', $user->id)->with('status', 'Profile berhasil diupdate.');
    }
}
