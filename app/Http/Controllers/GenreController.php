<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreGenreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $genres = Genre::findOrFail($id);
        return view('Genre.edit', compact('genres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGenreRequest $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:genres,genre_name,' . $id,
        ]);

        $genre = Genre::findOrFail($id);
        $genre->genre_name = $request->name;
        $genre->save();

        return redirect()->route('genres.index')->with('success', 'Cập nhật thể loại thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        //
    }
}
