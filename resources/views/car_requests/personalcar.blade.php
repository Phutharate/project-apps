@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-primary text-white py-3">
                <h2 class="mb-0 text-center fw-bold">
                    <i class="fas fa-car me-2"></i>ฟอร์มขอใช้รถส่วนตัว
                </h2>
            </div>

            <div class="card-body p-4 p-md-5">
                {{-- แสดงข้อความสำเร็จ --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- แสดง error --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('personal-car-requests.store') }}" enctype="multipart/form-data"
                    class="needs-validation" novalidate>
                    @csrf

                    <div class="row g-4 mb-4">
                        <!-- ส่วนข้อมูลผู้ขอใช้รถ -->
                        <div class="col-12">
                            <h5 class="fw-bold text-primary mb-3 pb-2 border-bottom">
                                <i class="fas fa-user-circle me-2"></i>ข้อมูลผู้ขอใช้รถ
                            </h5>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">ชื่อ-สกุล</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user text-primary"></i></span>
                                <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">เบอร์โทร <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-phone text-primary"></i></span>
                                <input type="text" name="phone" class="form-control" required
                                    value="{{ old('phone') }}">
                                <div class="invalid-feedback">กรุณากรอกเบอร์โทร</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">ตำแหน่ง</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-briefcase text-primary"></i></span>
                                <input type="text" name="position" class="form-control"
                                    value="{{ Auth::user()->position }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">แผนก / กลุ่ม</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-building text-primary"></i></span>
                                <input type="text" name="department" class="form-control"
                                    value="{{ Auth::user()->department }}" readonly>
                            </div>
                        </div>

                        <!-- ส่วนข้อมูลรถ -->
                        <div class="col-12 mt-4">
                            <h5 class="fw-bold text-primary mb-3 pb-2 border-bottom">
                                <i class="fas fa-car me-2"></i>ข้อมูลรถ
                            </h5>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">ยี่ห้อรถ <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-car-side text-primary"></i></span>
                                <input type="text" name="car_brand" class="form-control" required
                                    value="{{ old('car_brand') }}">
                                <div class="invalid-feedback">กรุณากรอกยี่ห้อรถ</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">ทะเบียนรถ <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-id-card text-primary"></i></span>
                                <input type="text" name="car_registration" class="form-control" required
                                    value="{{ old('car_registration') }}">
                                <div class="invalid-feedback">กรุณากรอกทะเบียนรถ</div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">จำนวนที่นั่ง <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-users text-primary"></i></span>
                                <input type="number" name="seats" class="form-control" required
                                    value="{{ old('seats') }}" min="1">
                                <div class="invalid-feedback">กรุณากรอกจำนวนที่นั่ง</div>
                            </div>
                        </div>

                        <!-- ส่วนข้อมูลการเดินทาง -->
                        <div class="col-12 mt-4">
                            <h5 class="fw-bold text-primary mb-3 pb-2 border-bottom">
                                <i class="fas fa-route me-2"></i>ข้อมูลการเดินทาง
                            </h5>
                        </div>

                        <div class="col-md-9">
                            <label class="form-label fw-bold">สถานที่ไป <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i
                                        class="fas fa-map-marker-alt text-primary"></i></span>
                                <input type="text" name="destination" class="form-control" required
                                    value="{{ old('destination') }}">
                                <div class="invalid-feedback">กรุณากรอกสถานที่ไป</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">จังหวัด <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i
                                        class="fas fa-map-marked-alt text-primary"></i></span>
                                <input type="text" name="province" class="form-control" required
                                    value="{{ old('province') }}">
                                <div class="invalid-feedback">กรุณากรอกจังหวัด</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">วัตถุประสงค์ <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i
                                        class="fas fa-bullseye text-primary"></i></span>
                                <input type="text" name="purpose" class="form-control" required
                                    value="{{ old('purpose') }}">
                                <div class="invalid-feedback">กรุณากรอกวัตถุประสงค์</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">เวลาออกเดินทาง <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-clock text-primary"></i></span>
                                <input type="text" name="start_time" id="start_time" class="form-control" required>
                                <div class="invalid-feedback">กรุณาเลือกเวลาออกเดินทาง</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">เวลากลับ <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-clock text-primary"></i></span>
                                <input type="text" name="end_time" id="end_time" class="form-control" required>
                                <div class="invalid-feedback">กรุณาเลือกเวลากลับ</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">เหตุผลเพิ่มเติม (ถ้ามี)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i
                                        class="fas fa-comment-dots text-primary"></i></span>
                                <textarea name="reason" class="form-control" rows="3">{{ old('reason') }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">แนบไฟล์ (ถ้ามี)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i
                                        class="fas fa-paperclip text-primary"></i></span>
                                <input type="file" name="attachment" class="form-control">
                            </div>
                            <small class="text-muted">สามารถอัพโหลดไฟล์ PDF, JPG, PNG ขนาดไม่เกิน 5MB</small>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold">
                            <i class="fas fa-paper-plane me-2"></i>ส่งคำขอใช้รถส่วนตัว
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
            border: none;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            border-radius: 0.3rem 0.3rem 0 0 !important;
        }

        .form-label {
            margin-bottom: 0.5rem;
        }

        .input-group-text {
            min-width: 45px;
            justify-content: center;
        }

        .btn-primary {
            background-color: #3b7ddd;
            border-color: #3b7ddd;
            box-shadow: 0 4px 6px rgba(59, 125, 221, 0.3);
        }

        .btn-primary:hover {
            background-color: #2f6bc5;
            border-color: #2f6bc5;
            transform: translateY(-2px);
        }

        .invalid-feedback {
            display: none;
            color: #dc3545;
        }

        .was-validated .form-control:invalid~.invalid-feedback,
        .form-control.is-invalid~.invalid-feedback {
            display: block;
        }

        .was-validated .form-control:invalid,
        .form-control.is-invalid {
            border-color: #dc3545;
        }
    </style>
@endpush

@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>

    <script>
        // ฟังก์ชันสำหรับตรวจสอบฟอร์มก่อน submit
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        function formatBuddhistDate(dateObj) {
            const buddhistYear = dateObj.getFullYear() + 543;
            const monthNames = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.',
                'ธ.ค.'
            ];
            return `${dateObj.getDate()} ${monthNames[dateObj.getMonth()]} ${buddhistYear} ${dateObj.getHours().toString().padStart(2, '0')}:${dateObj.getMinutes().toString().padStart(2, '0')}`;
        }

        function initThaiDatepicker(id) {
            flatpickr(id, {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "th",
                altInput: true,
                altFormat: "j M Y H:i",
                minDate: "today",
                maxDate: new Date().fp_incr(30), // กำหนดล่วงหน้าได้ 30 วัน
                onReady: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length) {
                        instance.altInput.value = formatBuddhistDate(selectedDates[0]);
                    }
                },
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length) {
                        instance.altInput.value = formatBuddhistDate(selectedDates[0]);
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initThaiDatepicker("#start_time");
            initThaiDatepicker("#end_time");
        });
    </script>
@endpush
