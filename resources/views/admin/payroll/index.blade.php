@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Bảng lương tháng {{ $month }}</h2>

    <!-- Form lọc -->
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Tháng</label>
            <input type="month" name="month" class="form-control" value="{{ $month }}">
        </div>

        <div class="col-md-3">
            <label>Nhân viên</label>
            <select name="user_id" class="form-select">
                <option value="">-- Tất cả --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $userId ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Lọc</button>
        </div>
    </form>

    <!-- Bảng kết quả -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nhân viên</th>
                <th>Tổng giờ</th>
                <th>Lương tạm tính (VNĐ)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payrolls as $payroll)
                <tr>
                    <td>{{ $payroll->user->name }}</td>
                    <td>{{ $payroll->total_hours }}</td>
                    <td>{{ number_format($payroll->total_salary, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Không có dữ liệu.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
