<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Http\Requests\StoreCinemaRequest;
use App\Http\Requests\UpdateCinemaRequest;
use App\Models\Location;
use App\Models\Movie;
use App\Models\Showtime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CinemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cinemas = Cinema::with('location')->get();
        return view('Cinema.index', compact('cinemas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all();
        return view('Cinema.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCinemaRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location_id' => 'required|integer|exists:locations,id',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        Cinema::create([
            'name' => $request->name,
            'location_id' => $request->location_id,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'description' => $request->description,
        ]);

        return Redirect::route('admin.cinemas')->with('success', 'Thêm rạp thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cinema $cinema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cinema = Cinema::findOrFail($id);
        $locations = Location::all();
        return view('Cinema.edit', compact('cinema', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'location_id' => 'required|exists:locations,id',
        ]);

        $cinema = Cinema::findOrFail($id);
        $cinema->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'description' => $request->description,
            'location_id' => $request->location_id,
        ]);

        return redirect()->route('admin.cinemas')->with('success', 'Cập nhật thông tin rạp thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cinema = Cinema::findOrFail($id);

        // Lấy tất cả room_id thuộc rạp
        $room_ids = $cinema->rooms()->pluck('id');

        // Lấy tất cả movie_id được chiếu ở các phòng của rạp
        $movie_ids = Showtime::whereIn('room_id', $room_ids)->pluck('movie_id')->unique();

        // Kiểm tra có phim nào chưa chiếu hoặc đang chiếu không (release_date >= hôm nay)
        $has_active_movies = Movie::whereIn('id', $movie_ids)
            ->whereDate('release_date', '>=', Carbon::today()->toDateString())
            ->exists();

        if ($has_active_movies) {
            return redirect()->back()->with('error', 'Không thể xoá rạp vì có phim đang hoặc sắp chiếu tại rạp này.');
        }

        // Nếu không có phim sắp chiếu, xoá rạp
        $cinema->delete();

        return redirect()->route('admin.cinemas')->with('success', 'Xoá rạp thành công!');
    }
}
