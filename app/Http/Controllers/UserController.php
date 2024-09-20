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
        $query = $request->input('search');

        $users = DB::table('users');

        if ($query) {
            // Filter pengguna berdasarkan pencarian
            $users->where('name', 'like', '%' . $query . '%');
        }

        // Jika request berasal dari AJAX, kembalikan JSON
        if ($request->ajax()) {
            $users = $users->get();
            return response()->json($users);
        }

        // Jika bukan AJAX, lakukan paginasi dan tampilkan view
        $users = User::paginate(100);
        return view('users.index', compact('users'));
    }


    // app/Http/Controllers/UserController.php
    // public function search(Request $request)
    // {
    //     $searchTerm = $request->get('query');
    //     $users = User::where('name', 'LIKE', '%' . $searchTerm . '%')->get();

    //     return response()->json($users);
    // }

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
