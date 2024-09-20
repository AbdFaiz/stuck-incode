<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        // Retrieve users with pagination (10 users per page)
        $users = User::paginate(100);
        return view('users.index', compact('users'));
    }

    // app/Http/Controllers/UserController.php
public function search(Request $request)
{
    $searchTerm = $request->get('query');
    $users = User::where('name', 'LIKE', '%' . $searchTerm . '%')->get();
    
    return response()->json($users);
}

}


