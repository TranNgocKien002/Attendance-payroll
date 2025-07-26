<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
     // Check-in
    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
                                ->where('work_date', $today)
                                ->first();

        if ($attendance && $attendance->check_in) {
            return response()->json(['message' => 'Bạn đã check-in hôm nay rồi.'], 409);
        }

        $attendance = Attendance::updateOrCreate(
            ['user_id' => $user->id, 'work_date' => $today],
            ['check_in' => Carbon::now()]
        );

        return response()->json(['message' => 'Check-in thành công.', 'data' => $attendance]);
    }

    // Check-out
    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
                                ->where('work_date', $today)
                                ->first();

        if (! $attendance || ! $attendance->check_in) {
            return response()->json(['message' => 'Bạn chưa check-in.'], 400);
        }

        if ($attendance->check_out) {
            return response()->json(['message' => 'Bạn đã check-out rồi.'], 409);
        }

        $attendance->check_out = Carbon::now();
        $attendance->save();

        return response()->json(['message' => 'Check-out thành công.', 'data' => $attendance]);
    }
}
