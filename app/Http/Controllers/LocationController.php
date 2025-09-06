<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Location;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();
        return view('Location.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Location.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request)
    {
        $request->validate([
            'location_name' => 'required|string|max:255',
        ]);

        Location::create([
            'location_name' => $request->location_name,
        ]);

        return redirect()->route('admin.locations')->with('success', 'Thêm vị trí thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('Location.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'location_name' => 'required|string|max:255',
        ]);

        $location = Location::findOrFail($id);
        $location->update([
            'location_name' => $request->location_name,
        ]);

        return redirect()->route('admin.locations')->with('success', 'Cập nhật địa điểm thành công!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cinemaCount = Cinema::where('location_id', $id)->count();

        if ($cinemaCount > 0) {
            return redirect()->back()->with('error', 'Không thể xoá vị trí do vẫn còn rạp nằm trong vị trí này!');
        }

        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('locations.index')->with('success', 'Đã xoá vị trí thành công.');
    }
}
