<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $user = User::with(['questions', 'answers'])->findOrFail($id);
        return view('users.show', compact('user'));
    }


}
