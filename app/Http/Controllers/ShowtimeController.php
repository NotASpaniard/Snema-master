<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Room;
use App\Models\Showtime;
use App\Http\Requests\StoreShowtimeRequest;
use App\Http\Requests\UpdateShowtimeRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShowtimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $showtimes = Showtime::with('movie', 'room')->paginate(5);
        return view('Showtime.index', compact('showtimes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $movies = Movie::all();
        $rooms = Room::with('cinema')->get();

        return view('Showtime.create', compact('movies', 'rooms'));
    }

    public function checkConflict(Request $request)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:1',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $start_time = Carbon::createFromFormat('H:i', $request->start_time);
        $end_time = $start_time->copy()->addMinutes($request->duration);

        $conflict = Showtime::where('room_id', $request->room_id)
            ->where('status', 1)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('start_time', [$start_time->format('H:i:s'), $end_time->format('H:i:s')])
                    ->orWhereBetween('end_time', [$start_time->format('H:i:s'), $end_time->format('H:i:s')])
                    ->orWhere(function ($query) use ($start_time, $end_time) {
                        $query->where('start_time', '<', $start_time->format('H:i:s'))
                            ->where('end_time', '>', $end_time->format('H:i:s'));
                    });
            })
            ->exists();

        return response()->json(['conflict' => $conflict]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'room_id' => 'required|exists:rooms,id',
            'movie_id' => 'required|exists:movies,id',
            'status' => 'required|in:0,1', // Nếu bạn cho chọn thủ công
        ]);

        $movie = Movie::findOrFail($request->movie_id);
        $start_time = Carbon::createFromFormat('H:i', $request->start_time);
        $end_time = $start_time->copy()->addMinutes($movie->duration);

        $hour = (int) $start_time->format('H');
        $extra_price = ($hour >= 16 && $hour < 22) ? 10000 : 0;

        // Kiểm tra xung đột chỉ với lịch chiếu đang hoạt động (status = 1)
        $conflict = \App\Models\Showtime::where('room_id', $request->room_id)
            ->where('status', 1)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->whereBetween('start_time', [$start_time->format('H:i:s'), $end_time->format('H:i:s')])
                    ->orWhereBetween('end_time', [$start_time->format('H:i:s'), $end_time->format('H:i:s')])
                    ->orWhere(function ($query) use ($start_time, $end_time) {
                        $query->where('start_time', '<', $start_time->format('H:i:s'))
                            ->where('end_time', '>', $end_time->format('H:i:s'));
                    });
            })
            ->exists();

        if ($conflict) {
            return redirect()->back()->withInput()->withErrors([
                'start_time' => 'Lịch chiếu bị trùng thời gian với lịch đang hoạt động trong phòng này.',
            ]);
        }

        // Tạo showtime mới
        Showtime::create([
            'start_time' => $start_time->format('H:i:s'),
            'end_time' => $end_time->format('H:i:s'),
            'room_id' => $request->room_id,
            'movie_id' => $request->movie_id,
            'price' => $extra_price,
            'status' => $request->status ?? 1, // mặc định 1 nếu không truyền
        ]);

        return redirect()->route('admin.showtimes')->with('success', 'Lịch chiếu đã được thêm thành công!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Showtime $showtime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $showtime = Showtime::findOrFail($id);
        $movies = Movie::all();
        $rooms = Room::with('cinema')->get();

        return view('Showtime.edit', compact('showtime', 'movies', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'room_id'    => 'required|exists:rooms,id',
            'movie_id'   => 'required|exists:movies,id',
            'status'     => 'required|in:0,1',
        ]);

        $showtime = Showtime::findOrFail($id);
        $movie = Movie::findOrFail($request->movie_id);

        $new_start = Carbon::createFromFormat('H:i', $request->start_time);
        $old_start = Carbon::createFromFormat('H:i:s', $showtime->start_time);
        $new_end = $new_start->copy()->addMinutes($movie->duration);
        $hour = (int) $new_start->format('H');
        $extra_price = ($hour >= 16 && $hour < 22) ? 10000 : 0;

        // Giờ chiếu mới sớm hơn giờ cũ
        if ($new_start->lt($old_start)) {
            return redirect()->back()->withInput()->withErrors([
                'start_time' => 'Không được chỉnh giờ chiếu sớm hơn giờ cũ.',
            ]);
        }

        // Giờ bắt đầu quá muộn
        if ($hour >= 22) {
            return redirect()->back()->withInput()->withErrors([
                'start_time' => 'Không được đặt lịch chiếu sau 22:00.',
            ]);
        }

        // Check xung đột với các showtime khác trong cùng phòng
        $conflict = Showtime::where('room_id', $request->room_id)
            ->where('id', '!=', $showtime->id) // bỏ qua chính nó
            ->where('status', 1)
            ->where(function ($query) use ($new_start, $new_end) {
                $query->whereBetween('start_time', [$new_start->format('H:i:s'), $new_end->format('H:i:s')])
                    ->orWhereBetween('end_time', [$new_start->format('H:i:s'), $new_end->format('H:i:s')])
                    ->orWhere(function ($q) use ($new_start, $new_end) {
                        $q->where('start_time', '<', $new_start->format('H:i:s'))
                            ->where('end_time', '>', $new_end->format('H:i:s'));
                    });
            })
            ->exists();

        if ($conflict) {
            return redirect()->back()->withInput()->withErrors([
                'start_time' => 'Thời gian chiếu mới bị trùng với lịch chiếu khác trong phòng!',
            ]);
        }

        // Cập nhật nếu hợp lệ
        $showtime->update([
            'start_time'   => $new_start->format('H:i:s'),
            'end_time'     => $new_end->format('H:i:s'),
            'room_id'      => $request->room_id,
            'movie_id'     => $request->movie_id,
            'status'       => $request->status,
            'price'  => $extra_price,
        ]);

        return redirect()->route('admin.showtimes')->with('success', 'Cập nhật lịch chiếu thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $showtime = Showtime::findOrFail($id);
        $movie = Movie::findOrFail($showtime->movie_id);

        // Kiểm tra ngày chiếu
        if ($movie->release_date >= Carbon::today()->toDateString()) {
            return redirect()->back()->with('error', 'Không thể xoá giờ chiếu vì phim này vẫn chưa hết thời gian chiếu.');
        }

        $showtime->delete();

        return redirect()->route('showtimes.index')->with('success', 'Xoá lịch chiếu thành công!');
    }
}
