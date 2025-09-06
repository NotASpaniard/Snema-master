<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Location;
use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Seat;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with(['cinema'])->get();
        return view('Room.index', compact('rooms'));
    }

    public function viewSeats($id)
    {
        $room = Room::with('seats')->findOrFail($id);
        return view('Room.seats', compact('room'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cinemas = Cinema::with(['location'])->get();
        return view('Room.create', compact('cinemas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required',
            'total_seat' => 'required|integer|min:1',
            'cinema_id' => 'required|exists:cinemas,id',
        ]);

        // Lấy location_id từ cinema (nếu location là của cinema)
        $cinema = Cinema::findOrFail($request->cinema_id);
        $location_id = $cinema->location_id;

        // Kiểm tra trùng số phòng trong cùng location
        $exists = Room::where('room_number', $request->room_number)
            ->whereHas('cinema', function ($q) use ($location_id) {
                $q->where('location_id', $location_id);
            })
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors(['room_number' => 'Số phòng này đã tồn tại tại địa điểm này.'])
                ->withInput();
        }

        // Nếu không trùng, tiếp tục tạo phòng như cũ
        $room = Room::create([
            'room_number' => $request->room_number,
            'total_seat' => $request->total_seat,
            'cinema_id' => $request->cinema_id,
        ]);

        // Tạo ghế
        $total = $request->total_seat;
        $colsPerRow = 8;
        $currentRow = 'A';
        $rowCount = 0;

        for ($i = 1; $i <= $total; $i++) {
            if (($i - 1) % $colsPerRow == 0 && $i > 1) {
                $currentRow++;
                $rowCount = 0;
            }

            $rowCount++;
            $seat_code = $currentRow . $rowCount;

            // Gán seat_type dựa theo hàng
            $seat_type = in_array($currentRow, ['A', 'B']) ? 'vip' : 'normal';
            $seat_price = $seat_type === 'vip' ? 50000 : 45000;

            Seat::create([
                'room_id' => $room->id,
                'seat_code' => $seat_code,
                'seat_number' => $i,
                'seat_type' => $seat_type,
                'seat_status' => '1',
                'seat_price' => $seat_price
            ]);
        }

        return redirect()->route('admin.rooms')->with('success', 'Tạo phòng và ghế thành công!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $room = Room::with(['cinema.location'])->findOrFail($id);
        $cinema = Cinema::with(['location'])->findOrFail($room->cinema_id);
        $location = Location::with(['cinema'])->get();
        return view('Room.edit', compact('room', 'cinema', 'location'));
    }

    /**
     * Update the specified resource in storage.
     */
        public function update(Request $request, $id)
    {
        $request->validate([
            'room_number' => 'required',
            'total_seat' => 'required|integer|min:1',
            'cinema_id' => 'required|exists:cinemas,id',
        ]);

        $room = Room::findOrFail($id);
        $oldSeatCount = $room->total_seat;
        $newSeatCount = $request->total_seat;

        // Cập nhật thông tin phòng
        $room->update([
            'room_number' => $request->room_number,
            'total_seat' => $newSeatCount,
            'cinema_id' => $request->cinema_id,
        ]);

        $colsPerRow = 8;
        $currentRow = chr(65); // A
        $rowCount = 0;

        // 1. Nếu thêm ghế
        if ($newSeatCount > $oldSeatCount) {
            for ($i = $oldSeatCount + 1; $i <= $newSeatCount; $i++) {
                $rowIndex = floor(($i - 1) / $colsPerRow); // A, B, C...
                $currentRow = chr(65 + $rowIndex);
                $seatNumber = ($i - 1) % $colsPerRow + 1;

                $seat_code = $currentRow . $seatNumber;
                $seat_type = in_array($currentRow, ['A', 'B']) ? 'vip' : 'normal';
                $seat_price = $seat_type === 'vip' ? 50000 : 45000;

                Seat::create([
                    'room_id' => $room->id,
                    'seat_code' => $seat_code,
                    'seat_number' => $i,
                    'seat_type' => $seat_type,
                    'seat_status' => '1',
                    'seat_price' => $seat_price,
                ]);
            }
        }

        // 2. Nếu giảm ghế
        if ($newSeatCount < $oldSeatCount) {
            Seat::where('room_id', $room->id)
                ->where('seat_number', '>', $newSeatCount)
                ->delete();
        }

        return redirect()->route('admin.rooms')->with('success', 'Cập nhật phòng và ghế thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        if ($room->showtimes()->count() > 0) {
            return back()->with('error', 'Không thể xoá phòng đang có suất chiếu.');
        }


        // Xoá toàn bộ ghế thuộc phòng
        Seat::where('room_id', $room->id)->delete();

        // Sau đó xoá phòng
        $room->delete();

        return redirect()->route('admin.rooms')->with('success', 'Đã xoá phòng và toàn bộ ghế thành công.');
    }

}
