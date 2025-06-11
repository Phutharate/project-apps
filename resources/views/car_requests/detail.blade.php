@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- ส่วนหัวหน้า -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-primary">
            <i class="bi bi-car-front me-2"></i>รายละเอียดคำขอใช้รถส่วนตัว
        </h2>
        <span class="badge fs-6 
            @if($request->status == 'approved') bg-success
            @elseif($request->status == 'rejected') bg-danger
            @else bg-warning text-dark @endif">
            @if($request->status == 'approved') อนุมัติแล้ว
            @elseif($request->status == 'rejected') ไม่อนุมัติ
            @else รออนุมัติ @endif
        </span>
    </div>

    <!-- การ์ดหลัก -->
    <div class="card border-0 shadow-lg">
        <div class="card-body p-4">
            <!-- แถวแรก - ข้อมูลผู้ขอและข้อมูลรถ -->
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
                        <p class="mb-1"><strong>เบอร์โทร:</strong></p>
                        <p class="bg-light p-2 rounded">{{ $request->phone }}</p>
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
                        <p class="mb-1"><strong>ยี่ห้อรถ:</strong></p>
                        <p class="bg-light p-2 rounded">{{ $request->car_brand }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="mb-1"><strong>ทะเบียนรถ:</strong></p>
                        <p class="bg-light p-2 rounded">{{ $request->car_registration }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="mb-1"><strong>จังหวัด:</strong></p>
                        <p class="bg-light p-2 rounded">{{ $request->province }}</p>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- แถวที่สอง - ข้อมูลการเดินทางและเวลา -->
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
                </div>

                <div class="col-md-6">
                    <h5 class="text-primary mb-3">
                        <i class="bi bi-clock me-2"></i>ช่วงเวลา
                    </h5>
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

            <!-- หมายเหตุ -->
            <div class="mt-3">
                <h5 class="text-primary mb-3">
                    <i class="bi bi-chat-left-text me-2"></i>หมายเหตุ/เหตุผล
                </h5>
                <div class="bg-light p-3 rounded">
                    {{ $request->reason ?? 'ไม่มีหมายเหตุ' }}
                </div>
            </div>

            <!-- ไฟล์แนบ (ถ้ามี) -->
            @if ($request->attachment)
            <div class="mt-4">
                <h5 class="text-primary mb-3">
                    <i class="bi bi-paperclip me-2"></i>ไฟล์แนบ
                </h5>
                <a href="{{ asset('storage/' . $request->attachment) }}" 
                   target="_blank"
                   class="btn btn-outline-primary">
                   <i class="bi bi-download me-2"></i>ดาวน์โหลดไฟล์แนบ
                </a>
            </div>
            @endif

            <!-- ปุ่มดำเนินการ -->
            <div class="d-flex justify-content-between mt-4">
                
                <div>
                    <a href="{{ route('car_request.print', $request->id) }}" 
                       target="_blank"
                       class="btn btn-primary me-2">
                       <i class="bi bi-printer me-2"></i>พิมพ์ฟอร์มคำขอ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
    hr {
        border-top: 1px dashed #dee2e6;
    }
</style>
@endsection