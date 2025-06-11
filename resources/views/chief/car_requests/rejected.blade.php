@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-2">
    <div class="card shadow-sm border-0 w-100">
        <div class="card-body">
            <h3 class="mb-4 text-danger text-center fw-bold">
                ❌ รายการคำขอที่ไม่อนุมัติ
            </h3>

            @if ($requests->isEmpty())
                <div class="alert alert-info text-center">
                    ยังไม่มีคำขอที่ไม่อนุมัติ
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0 text-center w-100" style="min-width: 1300px;">
                        <thead class="table-danger">
                            <tr>
                                <th>รูป</th>
                                <th>พนักงานขับรถ</th>
                                <th>เบอร์คนขับ</th>
                                <th>จำนวนคนนั่ง</th>
                                <th>ทะเบียนรถ</th>
                                <th>รถ</th>
                                <th>ผู้ขอ</th>
                                <th>เบอร์ผู้ขอ</th>
                                <th>ตำแหน่ง</th>
                                <th>กลุ่ม</th>
                                <th>สถานที่</th>
                                <th>จังหวัด</th>
                                <th>เพื่อ (ไปทำอะไร)</th>
                                <th>เวลาที่ประชุม</th>
                                <th>เวลาไป / กลับ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $req)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/images/' . $req->car_image) }}"
                                            class="rounded shadow-sm"
                                            style="width: 100px; height: auto;" alt="car">
                                    </td>
                                    <td>{{ $req->driver }}</td>
                                    <td>{{ $req->driver_phone }}</td>
                                    <td>{{ $req->seats }} คน</td>
                                    <td>
                                        <span class="badge bg-primary text-white">
                                            {{ $req->car_registration }}
                                        </span>
                                    </td>
                                    <td>{{ $req->car_name }}</td>
                                    <td>{{ $req->name }}</td>
                                    <td>{{ $req->requester_phone ?? '-' }}</td>
                                    <td>{{ $req->position }}</td>
                                    <td>
                                        <span class="badge bg-secondary text-white">
                                            {{ $req->department }}
                                        </span>
                                    </td>
                                    <td>{{ $req->destination }}</td>
                                    <td>{{ $req->province }}</td>
                                    <td>{{ $req->purpose }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ \Carbon\Carbon::parse($req->meeting_datetime)->format('d/m/Y H:i') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ \Carbon\Carbon::parse($req->start_time)->format('d/m/Y H:i') }}<br>
                                            <small class="text-muted">ถึง</small><br>
                                            {{ \Carbon\Carbon::parse($req->end_time)->format('d/m/Y H:i') }}
                                        </span>
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
    .table, .table th, .table td {
        font-size: 0.9rem;
        vertical-align: middle !important;
        text-align: center;
        padding: 0.65rem 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .badge {
        font-size: 0.8rem;
        padding: 4px 8px;
        display: inline-block;
        max-width: 120px;
    }

    .card {
        border-radius: 0.5rem;
    }

    .container-fluid {
        padding-left: 0;
        padding-right: 0;
    }

    img {
        object-fit: cover;
    }
</style>
@endsection
