<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Genre;
use App\Models\GenreMovie;
use App\Models\Movie;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy tất cả phim
        $movies = Movie::all();
        return view('Admin.movies', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $movies = DB::table('movies')
            ->join('genre_movies', 'movies.genre_movie_id', '=', 'genre_movies.id')
            ->join('genres', 'genre_movies.genre_id', '=', 'genres.id')
            ->select('movies.*', 'genres.genre_name as genre_name', 'genres.id as genre_id')
            ->get();
        $genres = Genre::all();
        return view('movies.create', compact('movies', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_date' => 'required|date',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'author' => 'required|string|max:255',
            'duration' => 'required|integer',
            'rating' => 'required|numeric|between:1,5',
            'comment' => 'nullable|string',
            'trailer' => 'nullable|string',
            'language' => 'nullable|string',
            'genre_movie_id' => 'required|exists:genre_movies,id',
            'caption' => 'nullable|string',
        ]);

        $image_name = null;

        if ($request->hasFile('poster')) {
            $image_name =$request->file('poster')->getClientOriginalName();
            $request->file('poster')->storeAs('', $image_name, 'public');
        }

        Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            'release_date' => $request->release_date,
            'poster' => $image_name,
            'author' => $request->author,
            'duration' => $request->duration,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'trailer' => $request->trailer,
            'language' => $request->language,
            'genre_movie_id' => $request->genre_movie_id,
            'caption' => $request->caption,
        ]);

        return redirect()->route('admin.movies')->with('success', 'Đã thêm phim thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function details($id)
    {
        $cinemas = Cinema::all();
        $showtimes = Showtime::where('movie_id', $id)->get();
        $movies = Movie::with('genre_movie.genre')->findOrFail($id);
        return view('movies.movie_details', compact('movies', 'cinemas', 'showtimes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $movie = Movie::with('genre_movie.genre')->findOrFail($id);
        $genre_movies = GenreMovie::with('genre')->get();
        return view('Movies.edit', compact('movie', 'genre_movies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'required|date|after_or_equal:today',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png',
            'author' => 'nullable|string',
            'duration' => 'nullable|integer',
            'language' => 'nullable|string',
            'caption' => 'nullable|string',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:10',
            'genre_movie_id' => 'nullable|exists:genre_movies,id',
            'trailer' => 'nullable|string',
        ]);

        $movie = Movie::findOrFail($id);

        $movie->update([
            'title' => $request->title,
            'release_date' => $request->release_date,
            'author' => $request->author,
            'duration' => $request->duration,
            'language' => $request->language,
            'caption' => $request->caption,
            'description' => $request->description,
            'rating' => $request->rating,
            'genre_movie_id' => $request->genre_movie_id,
            'trailer' => $request->trailer,
        ]);

        // Nếu người dùng upload poster mới
        if ($request->hasFile('poster')) {
            $poster_path = $request->file('poster')->store('', 'public');
            $movie->poster = $poster_path;
            $movie->save();
        }

        return redirect()->route('admin.movies')->with('success', 'Cập nhật phim thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie, Request $request)
    {
        $del_movie = new Movie();
        $del_movie->id = $request->id;
        $del_movie->destroyMovie();
        return Redirect::route('admin.movies')->with('success', 'Xoá phim thành công!');
    }
}
