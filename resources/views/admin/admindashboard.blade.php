@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow rounded-4 border-0 bg-light">
                <div class="card-body">
                    <h2 class="card-title mb-4 text-center text-primary">
                        <i class="bi bi-speedometer2"></i> แดชบอร์ด
                    </h2>

                    <div class="alert alert-success text-center" role="alert">
                       
                        ยินดีต้อนรับเข้าสู่งานที่ได้รับมอบหมาย
                    </div>

                    <p class="card-text text-center">
                        คุณสามารถดูงานที่ได้รับมอบหมาย
                    </p>

                    <!--<div class="text-center mt-4">
                        <a href="{{ route('driver.assigned_jobs') }}" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                            <i class="bi bi-card-checklist me-2"></i> ดูงานที่ได้รับมอบหมาย
                        </a>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- เพิ่มไอคอน Bootstrap Icons ถ้ายังไม่ได้เพิ่ม -->
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush
@endsection

