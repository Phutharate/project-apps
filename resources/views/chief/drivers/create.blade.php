@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-user-plus me-2"></i>เพิ่มพนักงานขับรถใหม่
                </h4>
            </div>
            <div class="card-body">

                {{-- ✅ แสดง error ถ้ามี --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>พบข้อผิดพลาด:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <form method="POST" action="{{ route('chief.drivers.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-1"></i>ชื่อ-นามสกุล
                                </label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>อีเมล
                                </label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>รหัสผ่าน
                                </label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-1"></i>ยืนยันรหัสผ่าน
                                </label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-4" style="max-width: 300px;">
                            <label for="status" class="form-label">
                                <i class="fas fa-info-circle me-1"></i>สถานะการทำงาน
                            </label>
                            <select name="status" class="form-select form-select-sm" required>
                                <option value="ว่าง" {{ old('status') == 'ว่าง' ? 'selected' : '' }}>ว่าง</option>
                                <option value="กำลังปฏิบัติงาน" {{ old('status') == 'กำลังปฏิบัติงาน' ? 'selected' : '' }}>
                                    กำลังปฏิบัติงาน</option>
                                <option value="ลาพัก" {{ old('status') == 'ลาพัก' ? 'selected' : '' }}>ลาพัก</option>
                                <option value="ไม่พร้อม" {{ old('status') == 'ไม่พร้อม' ? 'selected' : '' }}>ไม่พร้อม
                                </option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save me-2"></i>บันทึก
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <style>
            .card {
                border-radius: 10px;
            }

            .form-control,
            .form-select {
                border-radius: 5px;
                padding: 10px;
            }

            .btn {
                border-radius: 5px;
                font-weight: 500;
            }
        </style>
    @endsection
