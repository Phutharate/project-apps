@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <div class="card shadow border-0 rounded-3">
            <!-- Card Header -->
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-car-front me-2"></i>รายการคำขอใช้รถราชการ
                    </h4>
                    @unless (Auth::user()->role === 'driver')
                        <div>
                            <a href="{{ route('personal-car-requests.index') }}" class="btn btn-light btn-sm">
                                <i class="bi bi-car me-1"></i> รายการรขอใช้รถส่วนตัว
                            </a>
                        </div>
                    @endunless
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body p-4">
                <!-- Create Button -->
                @if (!in_array(Auth::user()->role, ['driver', 'director']))
                    <div class="text-end mb-4">
                        <a href="{{ route('car-requests.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-2"></i>➕ สร้างคำขอใหม่
                        </a>
                    </div>
                @endif



                <!-- Empty State -->
                @if ($requests->isEmpty())
                    <div class="text-center py-5 my-4 bg-light rounded-3">
                        <i class="bi bi-car-front fs-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">ยังไม่มีคำขอใช้รถ</h5>
                        <p class="text-muted mb-4">คลิกที่ปุ่ม "สร้างคำขอใหม่" เพื่อเพิ่มคำขอ</p>
                    </div>
                @else
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border">
                            <thead class="table-light">
                                <tr>
                                    <th width="50px" class="text-center">ลำดับ</th>
                                    <th width="100px" class="text-center">รูปรถ</th>
                                    <th>ยี่ห้อรถ</th>
                                    <th>คนขับ</th>
                                    <th>เบอร์ติดต่อ</th>
                                    <th>สถานที่</th>
                                    <th>จังหวัด</th>
                                    <th>วัตถุประสงค์</th>
                                    <th width="80px" class="text-center">จำนวนคน</th>
                                    <th width="100px" class="text-center">ทะเบียน</th>
                                    <th width="120px" class="text-center">วันที่ประชุม</th>
                                    <th width="200px" class="text-center">วันเวลาไป-กลับ</th>
                                    <th width="120px" class="text-center">สถานะ</th>
                                    <th width="100px" class="text-center">ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $i => $req)
                                    <tr>
                                        <!-- ลำดับ -->
                                        <td class="text-center">{{ $i + 1 }}</td>

                                        <!-- รูปรถ -->
                                        <td class="text-center">
                                            <img src="{{ asset('storage/images/' . $req->car_image) }}"
                                                class="rounded shadow-sm border"
                                                style="width: 80px; height: 50px; object-fit: cover;"
                                                alt="รูปภาพรถ {{ $req->car_name }}">
                                        </td>

                                        <!-- รายละเอียดรถ -->
                                        <td>{{ $req->car_name }}</td>
                                        <td>{{ $req->driver }}</td>
                                        <td>{{ $req->driver_phone }}</td>
                                        <td>{{ $req->destination }}</td>
                                        <td>{{ $req->province }}</td>
                                        <td>{{ Str::limit($req->purpose, 25) }}</td>
                                        <td class="text-center">{{ $req->seats }} คน</td>
                                        <td class="text-center">{{ $req->car_registration }}</td>

                                        <!-- วันที่ประชุม -->
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($req->meeting_datetime)->format('d/m/Y H:i') }}
                                        </td>

                                        <!-- วันเวลาไป-กลับ -->
                                        <td class="text-center">
                                            <div class="d-flex flex-column">
                                                <span class="text-success">
                                                    <i class="bi bi-arrow-up-circle me-1"></i>
                                                    {{ \Carbon\Carbon::parse($req->start_time)->format('d/m/Y H:i') }}
                                                </span>
                                                <span class="text-danger">
                                                    <i class="bi bi-arrow-down-circle me-1"></i>
                                                    {{ \Carbon\Carbon::parse($req->end_time)->format('d/m/Y H:i') }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- สถานะ -->
                                        <td class="text-center">
                                            @if ($req->status == 'pending')
                                                <span class="badge bg-warning bg-opacity-20 text-warning">
                                                    <i class="bi bi-clock-history me-1"></i>รออนุมัติ
                                                </span>
                                            @elseif ($req->status == 'approved')
                                                <span class="badge bg-success bg-opacity-20 text-success">
                                                    <i class="bi bi-check-circle me-1"></i>อนุมัติ
                                                </span>
                                            @else
                                                <span class="badge bg-danger bg-opacity-20 text-danger">
                                                    <i class="bi bi-x-circle me-1"></i>ไม่อนุมัติ
                                                </span>
                                            @endif
                                        </td>

                                        <!-- ปุ่มดำเนินการ -->
                                        <td class="text-center">
                                            <a href="{{ route('car-requests.show', $req->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="ดูรายละเอียด">
                                                <i class="bi bi-eye me-1"></i>ดู
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
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
            background-color: #f8f9fa;
        }

        .table td {
            padding: 0.75rem 0.5rem;
            vertical-align: middle;
        }

        .badge {
            padding: 0.35em 0.65em;
            font-weight: 500;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }
    </style>
@endsection
