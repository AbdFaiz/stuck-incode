<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('search');
        $filter = $request->input('filter');

        $tags = DB::table('tags');

        if ($query) {
            $tags->where('name', 'like', '%' . $query . '%');
        }

        // Handle filtering based on 'filter' parameter
        if ($filter === 'popular') {
            $tags->orderBy('used_count', 'desc');
        } elseif ($filter === 'name') {
            $tags->orderBy('name', 'asc');
        } elseif ($filter === 'new') {
            $tags->orderBy('created_at', 'desc');
        }

        // Get filtered tags
        $tags = $tags->get();

        if ($request->ajax()) {
            return response()->json($tags);
        }

        return view('tags.index', compact('tags'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
