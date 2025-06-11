@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-2">
    <div class="card shadow-sm border-0 w-100">
        <div class="card-body">
            <h3 class="mb-4 text-primary text-center fw-bold">
                📝 รายการคำขอใช้รถ (รออนุมัติ)
            </h3>

            {{-- แจ้งเตือน --}}
            @if (session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @elseif(session('danger'))
                <div class="alert alert-danger text-center">{{ session('danger') }}</div>
            @endif

            {{-- ไม่มีรายการ --}}
            @if ($requests->isEmpty())
                <div class="alert alert-warning text-center">ยังไม่มีคำขอที่รออนุมัติ</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0 text-center w-100" style="min-width: 1400px;">
                        <thead class="table-light">
                            <tr>
                                <th>รูป</th>
                                <th>คนขับ</th>
                                <th>เบอร์คนขับ</th>
                                <th>ที่นั่ง</th>
                                <th>ทะเบียน</th>
                                <th>รถ</th>
                                <th>ผู้ขอ</th>
                                <th>เบอร์ผู้ขอ</th>
                                <th>ตำแหน่ง</th>
                                <th>กลุ่ม</th>
                                <th>สถานที่</th>
                                <th>จังหวัด</th>
                                <th>เพื่อ</th>
                                <th>ประชุม</th>
                                <th>เวลาไป/กลับ</th>
                                <th>ไฟล์แนบ</th>
                                <th>จัดการ</th>
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
                                    <td>{{ $req->seats }}</td>
                                    <td>
                                        <span class="badge bg-primary text-white">
                                            {{ Str::limit($req->car_registration, 15) }}
                                        </span>
                                    </td>
                                    <td>{{ $req->car_name }}</td>
                                    <td>{{ $req->name }}</td>
                                    <td>{{ $req->requester_phone }}</td>
                                    <td>{{ $req->position }}</td>
                                    <td>
                                        <span class="badge bg-secondary text-white">
                                            {{ Str::limit($req->department, 20) }}
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
                                    <td style="max-width: 160px;">
                                        @if($req->attachment_path)
                                            <a href="{{ asset('storage/' . $req->attachment_path) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-primary w-100"
                                               data-bs-toggle="tooltip" title="เปิดไฟล์แนบ">
                                                เปิดดู
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="{{ route('chief.car-requests.approve', $req->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success btn-sm rounded-circle p-2"
                                                    data-bs-toggle="tooltip" title="อนุมัติ"
                                                    onclick="return confirm('คุณแน่ใจหรือไม่ว่าจะอนุมัติคำขอนี้?')">
                                                    ✅
                                                </button>
                                            </form>
                                            <form action="{{ route('chief.car-requests.reject', $req->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle p-2"
                                                    data-bs-toggle="tooltip" title="ไม่อนุมัติ"
                                                    onclick="return confirm('คุณแน่ใจหรือไม่ว่าจะไม่อนุมัติคำขอนี้?')">
                                                    ❌
                                                </button>
                                            </form>
                                        </div>
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
        padding-right: 0;
        padding-left: 0;
    }

    td {
        white-space: normal !important;
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
