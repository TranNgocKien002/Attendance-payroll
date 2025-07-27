<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payroll;
use Carbon\Carbon;
use App\Models\User;

class PayrollAdminController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $userId = $request->input('user_id');

        $query = Payroll::with('user')->where('month', $month);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $payrolls = $query->get();
        $users = User::all(); // để chọn tên nhân viên

        return view('admin.payroll.index', compact('payrolls', 'month', 'userId', 'users'));
    }
}
