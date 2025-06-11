@extends('layouts.app')

@section('styles')


@section('content')
<div class="container mt-5">
    <h3 class="mb-4 text-primary fw-bold">บันทึกการใช้รถราชการ</h3>
     @yield('styles')
    {{-- แสดงข้อความเมื่อบันทึกสำเร็จ --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ปุ่มพิมพ์รายงาน --}}
<div id="print-button-wrapper" class="mb-3 text-end">
    <button class="btn btn-outline-secondary" onclick="window.print()">
        <i class="fas fa-print"></i> พิมพ์รายงาน
    </button>
</div>



    {{-- ตารางข้อมูล --}}
    <div class="table-responsive-lg shadow-sm">
        <table class="table table-bordered table-hover table-sm text-nowrap bg-white">
            <thead class="table-primary text-center">
                <tr>
                    <th style="width: 5%;">ลำดับ</th>
                    <th style="width: 10%;">วันที่ออก</th>
                    <th style="width: 8%;">เวลาออก</th>
                    <th style="width: 12%;">ผู้ใช้รถ</th>
                    <th style="width: 15%;">สถานที่ไป</th>
                    <th style="width: 10%;">เลขไมล์ออก</th>
                    <th style="width: 10%;">เลขไมล์กลับ</th>
                    <th style="width: 10%;">รวมระยะทาง</th>
                    <th style="width: 12%;">พนักงานขับรถ</th>
                    <th style="width: 10%;">วันที่กลับ</th>
                    <th style="width: 8%;">เวลากลับ</th>
                    <th style="width: 20%;">หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($carUsages as $usage)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($usage->date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($usage->time)->format('H:i') }}</td>
                        <td>{{ $usage->user_name }}</td>
                        <td>{{ $usage->destination }}</td>
                        <td class="text-end">{{ number_format($usage->start_mileage, 2) }}</td>
                        <td class="text-end">{{ number_format($usage->end_mileage, 2) }}</td>
                        <td class="text-end">{{ number_format($usage->total_distance, 2) }}</td>
                        <td>{{ $usage->driver_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($usage->return_date)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($usage->return_time)->format('H:i') }}</td>
                        <td>{{ $usage->notes }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center text-muted">ยังไม่มีข้อมูลการใช้รถ</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
@media print {
    #print-button-wrapper {
        display: none !important;
    }

    .table-responsive-lg {
        overflow: visible !important;
    }

    table {
        width: 100% !important;
        table-layout: auto !important;
    }
}
</style>
@endsection
