<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    public function index()
    {
        $slots = TimeSlot::orderBy('StartTime')->get();
        return view('timeslots.index', compact('slots'));
    }

    public function create()
    {
        return view('timeslots.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'StartTime' => 'required|date_format:H:i',
            'EndTime' => 'required|date_format:H:i|after:StartTime',
        ]);

        TimeSlot::create(array_merge($validated, [
            'IsAvailable' => true,
            'IsActive' => true,
        ]));

        return redirect()->route('timeslots.index')->with('success', 'Time slot added.');
    }

    public function destroy($id)
    {
        $slot = TimeSlot::findOrFail($id);
        $slot->delete();

        return back()->with('success', 'Time slot deleted.');
    }
}
