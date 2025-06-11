@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-0">
    <div class="d-flex justify-content-between align-items-center mb-4 px-3">
        <h2 class="text-success fw-bold" style="font-size: 1.8rem">
            <i class="fas fa-check-circle me-2"></i>รายการคำขอรถส่วนตัว (อนุมัติแล้ว)
        </h2>
        <!--@if (!$requests->isEmpty())
            <span class="badge bg-success rounded-pill px8 py-2" style="font-size: 1rem">
                <i class="fas fa-list-check me-1"></i> ทั้งหมด {{ $requests->count() }} รายการ
            </span>
        @endif-->
    </div>

    @if ($requests->isEmpty())
        <div class="alert alert-info d-flex align-items-center mx-3" style="font-size: 1.2rem">
            <i class="fas fa-info-circle me-2 fs-4"></i>
            <span>ยังไม่มีคำขอที่อนุมัติแล้ว</span>
        </div>
    @else
        <div class="card shadow-sm border-0 mx-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0" style="table-layout: fixed;">
                        <thead class="table-success text-center">
                            <tr>
                                <th>ชื่อ</th>
                                <th>เบอร์โทร</th>
                                <th>ตำแหน่ง</th>
                                <th>แผนก</th>
                                <th>ยี่ห้อรถ</th>
                                <th>ทะเบียน</th>
                                <th>ที่นั่ง</th>
                                <th>สถานที่ไป</th>
                                <th>จังหวัด</th>
                                <th>วัตถุประสงค์</th>
                                <th>เวลาออก</th>
                                <th>เวลากลับ</th>
                                <th>เหตุผล</th>
                                <th>ไฟล์แนบ</th>
                                <th>สถานะ</th>
                                <th>ดู</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $req)
                                <tr class="text-center">
                                    <td class="fw-semibold">{{ $req->name }}</td>
                                    <td>{{ $req->phone }}</td>
                                    <td>{{ $req->position }}</td>
                                    <td>
                                        <span class="badge bg-secondary text-white" title="{{ $req->department }}">
                                            {{ Str::limit($req->department, 20) }}
                                        </span>
                                    </td>
                                    <td>{{ $req->car_brand }}</td>
                                    <td>
                                        <span class="badge bg-primary text-white" title="{{ $req->car_registration }}">
                                            {{ Str::limit($req->car_registration, 15) }}
                                        </span>
                                    </td>
                                    <td>{{ $req->seats }}</td>
                                    <td>{{ $req->destination }}</td>
                                    <td>{{ $req->province }}</td>
                                    <td>{{ $req->purpose }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ \Carbon\Carbon::parse($req->start_time)->format('d/m/Y H:i') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            {{ \Carbon\Carbon::parse($req->end_time)->format('d/m/Y H:i') }}
                                        </span>
                                    </td>
                                    <td>{{ $req->reason ?? '-' }}</td>
                                    <td>
                                        @if ($req->attachment)
                                            <a href="{{ asset('storage/' . $req->attachment) }}" target="_blank"
                                               class="btn btn-sm btn-outline-primary rounded-circle p-2"
                                               data-bs-toggle="tooltip" title="ดูไฟล์แนบ">
                                                <i class="fas fa-paperclip" style="font-size: 1.1rem"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i> อนุมัติแล้ว
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('personal-car-requests.show', $req->id) }}"
                                           class="btn btn-outline-info rounded-circle p-2"
                                           data-bs-toggle="tooltip" title="ดูรายละเอียด">
                                            <i class="fas fa-eye" style="font-size: 1.1rem"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    body {
        overflow-x: hidden;
    }

    .table,
    .table th,
    .table td {
        font-size: 0.9rem;
        vertical-align: middle !important;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 0.6rem 0.5rem;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(25, 135, 84, 0.05);
    }

    .badge {
        font-size: 0.8rem;
        line-height: 1.2;
        padding: 4px 8px;
        max-width: 120px;
        display: inline-block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card {
        border-radius: 0;
        border-left: none;
        border-right: none;
    }

    .container-fluid {
        padding-right: 0;
        padding-left: 0;
    }
</style>

@section('scripts')
<script>
    $(document).ready(function () {
        $('[data-bs-toggle="tooltip"]').tooltip({ container: 'body' });
    });
</script>
@endsection
@endsection
