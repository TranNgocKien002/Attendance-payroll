<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payroll;
use Carbon\Carbon;

class PayrollAdminController extends Controller
{
     public function index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));

        $payrolls = Payroll::with('user')
            ->where('month', $month)
            ->get();
        return view('admin.payroll.index', compact('payrolls', 'month'));
    }
}
