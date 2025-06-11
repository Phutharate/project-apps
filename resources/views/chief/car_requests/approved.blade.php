@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 px-2">
    <div class="card shadow-sm border-0 w-100">
        <div class="card-body">
            <h3 class="mb-4 text-success text-center fw-bold">
                ✅ รายการคำขอที่อนุมัติแล้ว
            </h3>

            @if ($requests->isEmpty())
                <div class="alert alert-info text-center">ยังไม่มีคำขอที่ได้รับการอนุมัติ</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0 text-center w-100" style="min-width: 1400px;">
                        <thead class="table-success">
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
                                <th>ไฟล์แนบ</th>
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
                                    <td style="max-width: 240px;">
                                        @if($req->attachment_path)
                                            <div class="d-flex justify-content-center align-items-center gap-2 flex-nowrap">
                                                <a href="{{ asset('storage/' . $req->attachment_path) }}"
                                                   target="_blank"
                                                   class="btn btn-sm btn-outline-primary px-2 py-1 w-auto">
                                                    เปิดดู
                                                </a>

                                                @php
                                                    $ext = pathinfo($req->attachment_path, PATHINFO_EXTENSION);
                                                @endphp

                                                @if($ext === 'pdf')
                                                    <button type="button"
                                                            class="btn btn-sm btn-secondary px-2 py-1 w-auto"
                                                            data-bs-toggle="modal" data-bs-target="#modalPDF{{ $req->id }}">
                                                        ดูตัวอย่าง
                                                    </button>
                                                @endif
                                            </div>

                                            {{-- modal PDF --}}
                                            @if($ext === 'pdf')
                                                <div class="modal fade" id="modalPDF{{ $req->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $req->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalLabel{{ $req->id }}">เอกสารแนบ</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <embed src="{{ asset('storage/' . $req->attachment_path) }}" type="application/pdf" width="100%" height="600px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif(in_array($ext, ['jpg','jpeg','png','gif']))
                                                <div class="mt-2 text-center">
                                                    <img src="{{ asset('storage/' . $req->attachment_path) }}"
                                                         class="img-thumbnail shadow-sm"
                                                         style="max-width: 180px; max-height: 150px; object-fit: contain;">
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush
