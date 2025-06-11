@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 text-primary">
                <i class="bi bi-car-front me-2"></i>รายละเอียดคำขอใช้รถ
            </h2>
            <span
                class="badge fs-6 
                @if ($request->status == 'approved') bg-success
                @elseif($request->status == 'rejected') bg-danger
                @else bg-warning text-dark @endif">
                @if ($request->status == 'approved')
                    อนุมัติแล้ว
                @elseif($request->status == 'rejected')
                    ไม่อนุมัติ
                @else
                    รออนุมัติ
                @endif
            </span>
        </div>

        <div class="card border-0 shadow-lg overflow-hidden">
            <div class="row g-0">
                <!-- รูปภาพรถ -->
                <div class="col-md-4 bg-light d-flex align-items-center p-4">
                    @if ($request->car_image)
                        <img src="{{ asset('storage/images/' . $request->car_image) }}" alt="Car Image"
                            class="img-fluid rounded-3 shadow-sm w-100" style="max-height: 280px; object-fit: contain;">
                    @else
                        <div class="text-center w-100">
                            <i class="bi bi-car-front text-muted" style="font-size: 5rem;"></i>
                            <p class="text-muted mt-2">ไม่มีรูปภาพรถ</p>
                        </div>
                    @endif
                </div>

                <!-- ข้อมูลคำขอ -->
                <div class="col-md-8">
                    <div class="card-body p-4">
                        <div class="row">
                            <!-- ข้อมูลผู้ขอ -->
                            <div class="col-md-6 border-end">
                                <h5 class="text-primary mb-3">
                                    <i class="bi bi-person-badge me-2"></i>ข้อมูลผู้ขอ
                                </h5>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>ชื่อ-สกุล:</strong></p>
                                    <p class="bg-light p-2 rounded">{{ $request->name }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>เบอร์โทรผู้ขอ:</strong></p>
                                    <p class="bg-light p-2 rounded">{{ $request->requester_phone }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>ตำแหน่ง:</strong></p>
                                    <p class="bg-light p-2 rounded">{{ $request->position }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>กลุ่มงาน:</strong></p>
                                    <p class="bg-light p-2 rounded">{{ $request->department }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>จำนวนผู้โดยสาร:</strong></p>
                                    <p class="bg-light p-2 rounded">{{ $request->seats }} คน</p>
                                </div>
                            </div>

                            <!-- ข้อมูลรถ -->
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="bi bi-car-front me-2"></i>ข้อมูลรถ
                                </h5>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>ประเภทรถ:</strong></p>
                                    <p class="bg-light p-2 rounded">{{ $request->car_name }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>ทะเบียนรถ:</strong></p>
                                    <p class="bg-light p-2 rounded">{{ $request->car_registration }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>พนักงานขับรถ:</strong></p>
                                    <p class="bg-light p-2 rounded">{{ $request->driver ?? '-' }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>เบอร์คนขับรถ:</strong></p>
                                    <p class="bg-light p-2 rounded">{{ $request->driver_phone ?? '-' }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>จังหวัด:</strong></p>
                                    <p class="bg-light p-2 rounded">{{ $request->province }}</p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- ข้อมูลการเดินทาง -->
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="bi bi-geo-alt me-2"></i>ข้อมูลการเดินทาง
                                </h5>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>สถานที่:</strong></p>
                                    <p class="bg-light p-2 rounded">{{ $request->destination }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>วัตถุประสงค์:</strong></p>
                                    <p class="bg-light p-2 rounded">{{ $request->purpose }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>วันเวลาที่ประชุม:</strong></p>
                                    <p class="bg-light p-2 rounded">
                                        {{ \Carbon\Carbon::parse($request->meeting_datetime)->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="bi bi-clock me-2"></i>ช่วงเวลา
                                </h5>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>เวลาที่ขอรถ:</strong></p>
                                    <p class="bg-light p-2 rounded">
                                        {{ \Carbon\Carbon::parse($request->car_request_time)->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <p class="mb-1"><strong>เวลาไป-กลับ:</strong></p>
                                    <div class="bg-light p-2 rounded">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bi bi-arrow-up-right text-success me-2"></i>
                                            {{ \Carbon\Carbon::parse($request->start_time)->format('d/m/Y H:i') }}
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-arrow-down-left text-danger me-2"></i>
                                            {{ \Carbon\Carbon::parse($request->end_time)->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- หมายเหตุ/เหตุผล -->
                        <div class="mt-3">
                            <h5 class="text-primary mb-3">
                                <i class="bi bi-chat-left-text me-2"></i>หมายเหตุ/เหตุผล
                            </h5>
                            <div class="bg-light p-3 rounded">
                                {{ $request->reason ?? 'ไม่มีหมายเหตุ' }}
                            </div>
                        </div>

                        <!-- ปุ่มพิมพ์ -->
                        @if (Auth::user()->role !== 'chief')
                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('car_request.print', $request->id) }}" target="_blank"
                                    class="btn btn-primary">
                                    <i class="bi bi-printer me-2"></i>พิมพ์ฟอร์มคำขอ
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
