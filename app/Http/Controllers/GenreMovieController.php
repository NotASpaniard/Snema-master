<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\GenreMovie;
use App\Http\Requests\StoreGenreMovieRequest;
use App\Http\Requests\UpdateGenreMovieRequest;

class GenreMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::all();
        return view('Genre.index', compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Genre.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenreMovieRequest $request)
    {
        $request->validate([
            'genre_name' => 'required|string|max:100|unique:genres,genre_name',
        ]);

        // Tạo mới genre
        $genre = Genre::create([
            'genre_name' => $request->genre_name,
        ]);

        // Tạo genre_movie gắn với genre vừa tạo
        $genreMovie = GenreMovie::create([
            'genre_id' => $genre->id,
        ]);

        return redirect()->route('genres.index')->with('success', 'Thêm thể loại thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(GenreMovie $genreMovie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GenreMovie $genreMovie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGenreMovieRequest $request, GenreMovie $genreMovie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $genre_movie = GenreMovie::findOrFail($id);
        $genre_id = $genre_movie->genre_id;
        // Xoá bản ghi genre_movie trước
        $genre_movie->delete();
        // Kiểm tra xem genre có còn được dùng ở genre_movies khác không
        $genre_still_used = GenreMovie::where('genre_id', $genre_id)->exists();
        if (!$genre_still_used) {
            Genre::where('id', $genre_id)->delete();
        }
        return redirect()->route('genres.index')
            ->with('success', 'Đã xoá thể loại và liên kết thành công.');
    }
}
