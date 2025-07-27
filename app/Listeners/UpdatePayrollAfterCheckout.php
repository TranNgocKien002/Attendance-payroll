<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CheckOutCompleted;
use App\Models\Attendance;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UpdatePayrollAfterCheckout
{
    public function handle(CheckOutCompleted $event)
    {
        $user = $event->user;
        $today = Carbon::now()->toDateString();
        $month = Carbon::now()->format('Y-m');

        $attendance = Attendance::where('user_id', $user->id)
            ->where('work_date', $today)
            ->first();

        if (! $attendance || ! $attendance->check_in || ! $attendance->check_out) {
            return;
        }

        $hours = round((strtotime($attendance->check_out) - strtotime($attendance->check_in)) / 3600, 2);
        $salary = $hours * floatval($user->hourly_wage);

        Payroll::updateOrCreate(
            ['user_id' => $user->id, 'month' => $month],
            [
                'total_hours' => DB::raw('total_hours + ' . $hours),
                'total_salary' => DB::raw('total_salary + ' . $salary),
            ]
        );
    }
}
