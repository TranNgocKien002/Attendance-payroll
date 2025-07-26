@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Bảng Lương Tháng</h2>

    <form method="GET" action="{{ route('payroll.index') }}" class="row g-3 mb-4">
        <div class="col-auto">
            <input type="month" name="month" value="{{ request('month', now()->format('Y-m')) }}" class="form-control">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Lọc</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nhân viên</th>
                <th>Số giờ làm</th>
                <th>Tổng lương (VND)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payrolls as $index => $payroll)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $payroll->user->name }}</td>
                    <td>{{ $payroll->total_hours }}</td>
                    <td>{{ number_format($payroll->total_salary, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
