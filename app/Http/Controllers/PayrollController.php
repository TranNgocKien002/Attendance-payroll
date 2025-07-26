<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Payroll;
use App\Models\Attendance;
use Carbon\Carbon;

class PayrollController extends Controller
{
    public function calculate(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::now()->toDateString();
        $month = Carbon::now()->format('Y-m');

        $attendance = Attendance::where('user_id', $user->id)
            ->where('work_date', $today)
            ->first();

        if (! $attendance || ! $attendance->check_in || ! $attendance->check_out) {
            return response()->json(['message' => 'Chưa đủ dữ liệu check-in/check-out.'], 400);
        }

        $hours = round((strtotime($attendance->check_out) - strtotime($attendance->check_in)) / 3600, 2);
        $salary = $hours * floatval($user->hourly_wage);

        // Cập nhật hoặc tạo payroll
        $payroll = Payroll::firstOrNew([
            'user_id' => $user->id,
            'month' => $month,
        ]);

        $payroll->total_hours += $hours;
        $payroll->total_salary += $salary;
        $payroll->save();

        return response()->json([
            'message' => 'Đã cập nhật bảng lương tháng ' . $month,
            'data' => $payroll
        ]);
    }
}
