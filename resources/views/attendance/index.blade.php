@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Chấm công ngày {{ $today }}</h2>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <div class="card mt-4">
        <div class="card-body">
            <p><strong>Check-in:</strong> {{ $attendance->check_in ?? 'Chưa' }}</p>
            <p><strong>Check-out:</strong> {{ $attendance->check_out ?? 'Chưa' }}</p>

            @if (!$attendance || !$attendance->check_in)
                <form action="{{ route('attendance.checkin') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Check-in</button>
                </form>
            @elseif (!$attendance->check_out)
                <form action="{{ route('attendance.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success mt-2">Check-out</button>
                </form>
            @else
                <p class="text-success">✅ Bạn đã hoàn tất chấm công hôm nay.</p>
            @endif
        </div>
    </div>
</div>
@endsection
