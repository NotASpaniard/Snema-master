<?php

namespace App\Http\Controllers;

use App\Models\BookingDetail;
use App\Models\Seat;
use App\Http\Requests\StoreSeatRequest;
use App\Http\Requests\UpdateSeatRequest;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function bulkDisable(Request $request)
    {
        $request->validate([
            'seat_ids' => 'required|array',
            'seat_ids.*' => 'exists:seats,id',
        ]);

        $seats = Seat::whereIn('id', $request->seat_ids)->get();
        $toggled = [];

        foreach ($seats as $seat) {
            // Kiểm tra ghế đã được đặt chưa
            $is_booked = BookingDetail::where('seat_id', $seat->id)->exists();

            if ($is_booked) {
                continue; // Không cho đổi nếu đã được đặt
            }

            foreach ($seats as $seat) {
                $seat->seat_status = $seat->seat_status == 1 ? 0 : 1;
                $seat->save();
                $toggled[] = [
                    'id' => $seat->id,
                    'new_status' => $seat->seat_status,
                ];
            }

            return response()->json([
                'success' => true,
                'toggled' => $toggled,
            ]);
        }
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
    public function store(StoreSeatRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Seat $seat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seat $seat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeatRequest $request, Seat $seat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seat $seat)
    {
        //
    }
}
