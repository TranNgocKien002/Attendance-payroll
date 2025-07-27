<?php

namespace App\Http\Controllers\Web;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Events\CheckOutCompleted;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttendanceWebController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('work_date', $today)
            ->first();

        return view('attendance.index', compact('attendance', 'today'));
    }

    public function checkIn()
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();

        Attendance::firstOrCreate(
            ['user_id' => $user->id, 'work_date' => $today],
            ['check_in' => Carbon::now()]
        );

        return redirect()->route('attendance.index')->with('success', 'Check-in thành công');
    }

    public function checkOut()
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('work_date', $today)
            ->first();

        if ($attendance && !$attendance->check_out) {
            $attendance->update(['check_out' => Carbon::now()]);
            event(new CheckOutCompleted($user));
        }
        return redirect()->route('attendance.index')->with('success', 'Check-out thành công');
    }
}
