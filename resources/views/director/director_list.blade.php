@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0 text-center">
                <i class="bi bi-car-front me-2"></i>รายการคำขอใช้รถราชการ
            </h4>
        </div>

        <div class="card-body p-4">
            @if ($requests->isEmpty())
                <div class="alert alert-warning text-center py-4">
                    <i class="bi bi-exclamation-circle fs-4"></i>
                    <p class="mb-0 mt-2">ยังไม่มีคำขอใช้รถ</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>รูป</th>
                                <th>รถ</th>
                                <th>คนขับ</th>
                                <th>เบอร์คนขับ</th>
                                <th>สถานที่</th>
                                <th>จังหวัด</th>
                                <th>วัตถุประสงค์</th>
                                <th>จำนวนคนนั่ง</th>
                                <th>ทะเบียน</th>
                                <th>วันที่ประชุม</th>
                                <th>วันเวลาไป-กลับ</th>
                                <th>สถานะ</th>
                                <th>ดู</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $req)
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/images/' . $req->car_image) }}"
                                             class="rounded shadow-sm"
                                             style="width: 80px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>{{ $req->car_name }}</td>
                                    <td>{{ $req->driver }}</td>
                                    <td>{{ $req->driver_phone }}</td>
                                    <td>{{ $req->destination }}</td>
                                    <td>{{ $req->province }}</td>
                                    <td>{{ $req->purpose }}</td>
                                    <td class="text-center">{{ $req->seats }} คน</td>
                                    <td>{{ $req->car_registration }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($req->meeting_datetime)->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($req->start_time)->format('d/m/Y H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($req->end_time)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="text-center">
                                        @if ($req->status == 'pending')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-clock"></i> รออนุมัติ
                                            </span>
                                        @elseif ($req->status == 'approved')
                                            <span class="badge bg-success text-white">
                                                <i class="bi bi-check-circle"></i> อนุมัติ
                                            </span>
                                        @else
                                            <span class="badge bg-danger text-white">
                                                <i class="bi bi-x-circle"></i> ไม่อนุมัติ
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('car-requests.show', $req->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> ดู
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
@endsection
