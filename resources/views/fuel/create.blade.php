@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-gradient-primary text-white py-3">
                <h4 class="mb-0 fw-bold">
                    <i class="fas fa-gas-pump me-2"></i>บันทึกการใช้น้ำมันเชื้อเพลิง
                </h4>
            </div>

            <div class="card-body">
                <form action="{{ route('fuel.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <!-- แถวที่ 1: วันที่ + เลขใบสั่งจ่าย/ใบเสร็จ + เลขทะเบียน -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted">
                                <i class="far fa-calendar-alt me-1"></i>วันที่
                            </label>
                            <input type="date" name="date" class="form-control form-control-sm shadow-sm" required>
                            <div class="invalid-feedback">กรุณากรอกวันที่</div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-file-invoice me-1"></i>เลขใบสั่งจ่าย/ใบเสร็จรับเงิน
                            </label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm shadow-sm">
                                        <input type="text" name="fuel_order_number[]" class="form-control"
                                            placeholder="เล่มที่">
                                        <span class="input-group-text bg-light">เล่มที่</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm shadow-sm">
                                        <input type="text" name="receipt_number[]" class="form-control"
                                            placeholder="เลขที่">
                                        <span class="input-group-text bg-light">เลขที่</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-car me-1"></i>เลขทะเบียนรถ
                            </label>
                            <input type="text" name="license_plate" class="form-control form-control-sm shadow-sm"
                                placeholder="กข 1234">
                        </div>
                    </div>

                    <!-- แถวที่ 2: ระยะทาง / น้ำมัน / จำนวนเงิน -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-tachometer-alt me-1"></i>เลขระยะทางเมื่อขอเติม
                            </label>
                            <div class="input-group input-group-sm shadow-sm">
                                <input type="number" name="start_km" class="form-control" value="{{ $initialMileage }}"
                                    readonly>
                                <span class="input-group-text bg-light">กม.</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-road me-1"></i>รวมระยะทาง
                            </label>
                            <div class="input-group input-group-sm shadow-sm">
                                <input type="number" name="distance" class="form-control" value="{{ $distance }}"
                                    readonly>
                                <span class="input-group-text bg-light">กม.</span>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-gas-pump me-1"></i>น้ำมันเชื้อเพลิง
                            </label>
                            <div class="input-group input-group-sm shadow-sm">
                                <input type="number" step="0.01" name="fuel_liters" class="form-control"
                                    value="{{ $fuelLiters }}" readonly>
                                <span class="input-group-text bg-light">ลิตร</span>
                            </div>
                        </div>
                    </div>

                    <!-- แถวที่ 3: จำนวนเงิน + ผู้สั่งจ่าย + ผู้รับ -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-money-bill-wave me-1"></i>จำนวนเงิน
                            </label>
                            <div class="input-group input-group-sm shadow-sm">
                                <input type="number" name="amount_baht" class="form-control" value="{{ $amount_baht }}"
                                    readonly>
                                <span class="input-group-text bg-light">บาท</span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-user-tie me-1"></i>ผู้สั่งจ่าย
                            </label>
                            <input type="text" name="issued_by" class="form-control form-control-sm shadow-sm"
                                placeholder="ชื่อผู้สั่งจ่าย">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-muted">
                                <i class="fas fa-user-check me-1"></i>ผู้รับ
                            </label>
                            <input type="text" name="receiver" class="form-control form-control-sm shadow-sm"
                                placeholder="ชื่อผู้รับ">
                        </div>
                    </div>

                    <!-- หมายเหตุ -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-muted">
                            <i class="fas fa-sticky-note me-1"></i>หมายเหตุ
                        </label>
                        <textarea name="remark" rows="3" class="form-control shadow-sm" placeholder="ระบุหมายเหตุเพิ่มเติม (ถ้ามี)"></textarea>
                    </div>

                    <!-- ปุ่มดำเนินการ -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="reset" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-eraser me-1"></i>ล้างข้อมูล
                        </button>
                        <button type="submit" class="btn btn-success px-4 shadow">
                            <i class="fas fa-save me-1"></i>บันทึกข้อมูล
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            border-bottom: none;
        }

        .form-control,
        .input-group-text {
            border-radius: 6px !important;
        }

        .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15) !important;
        }

        .input-group-text {
            background-color: #f8f9fa;
            color: #495057;
        }

        .btn-success {
            background-color: #198754;
            border-color: #198754;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #157347;
            transform: translateY(-1px);
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Bootstrap validation
        (function() {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
@endpush
