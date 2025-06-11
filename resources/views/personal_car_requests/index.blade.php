@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow border-0 rounded-3">
            <!-- Card Header -->
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-car-front me-2"></i>รายการคำขอใช้รถส่วนตัว
                    </h4>
                    <!--@if (Auth::user()->role !== 'director') @endif -->
                    <div>
                        <a href="{{ route('car-requests.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-car me-1"></i> รายการคำขอใช้รถราชการ
                        </a>
                    </div>
                    
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body p-4">
                <!-- Create Button -->
                @if (!in_array(Auth::user()->role, ['driver', 'director']))
                    <div class="text-end mb-4">
                        <a href="{{ route('personal-car-requests.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-2"></i>➕ สร้างคำขอใหม่
                        </a>
                    </div>
                @endif



                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle w-100">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-center" style="width: 5%">ลำดับ</th>
                                <th style="width: 10%">ชื่อผู้ขอ</th>
                                <th style="width: 8%">เบอร์ติดต่อ</th>
                                <th style="width: 10%">ยี่ห้อรถ</th>
                                <th class="text-center" style="width: 8%">ทะเบียน</th>
                                <th style="width: 12%">สถานที่</th>
                                <th style="width: 8%">จังหวัด</th>
                                <th style="width: 12%">วัตถุประสงค์</th>
                                <th class="text-center" style="width: 10%">วันเวลาไป</th>
                                <th class="text-center" style="width: 10%">วันเวลากลับ</th>
                                <th class="text-center" style="width: 10%">สถานะ</th>
                                <th class="text-center" style="width: 7%">รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $i => $req)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>{{ $req->name }}</td>
                                    <td>{{ $req->phone }}</td>
                                    <td>{{ $req->car_brand }}</td>
                                    <td class="text-center">{{ $req->car_registration }}</td>
                                    <td>{{ $req->destination }}</td>
                                    <td>{{ $req->province }}</td>
                                    <td>{{ Str::limit($req->purpose, 30) }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($req->start_time)->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($req->end_time)->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        @if ($req->status === 'approved')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success">
                                                <i class="bi bi-check-circle-fill me-1"></i>อนุมัติ
                                            </span>
                                        @elseif($req->status === 'rejected')
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">
                                                <i class="bi bi-x-circle-fill me-1"></i>ไม่อนุมัติ
                                            </span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">
                                                <i class="bi bi-clock-fill me-1"></i>รอดำเนินการ
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('personal-car-requests.show', $req->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="ดูรายละเอียด"
                                            data-bs-toggle="tooltip">
                                            <i class="bi bi-eye-fill">ดู</i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center text-muted py-4">
                                        <i class="bi bi-info-circle-fill me-2"></i>ยังไม่มีคำขอใช้รถส่วนตัว
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table {
            font-size: 0.95rem;
        }

        .table th {
            white-space: nowrap;
            padding: 0.75rem 0.5rem;
        }

        .table td {
            padding: 0.75rem 0.5rem;
            vertical-align: middle;
        }

        .badge {
            padding: 0.35em 0.65em;
            font-weight: 500;
        }
    </style>
@endsection