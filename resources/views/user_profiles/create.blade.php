@extends('layouts.app')

@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-success text-white">เพิ่มผู้ใช้</div>
        <div class="card-body">
            <form action="{{ route('user-profiles.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">สิทธิ์ผู้ใช้ (Role)</label>
                        <select class="form-control" name="role" required>
                            <option value="">-- กรุณาเลือกสิทธิ์ --</option>
                            <option value="user">User</option>
                            {{-- <option value="chief">Chief</option> 
                            {{--<option value="admin">Admin</option> --}}
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">คำนำหน้า</label>
                        <select class="form-control" name="prefix" required>
                            <option value="">-- กรุณาเลือกคำนำหน้า --</option>
                            <option value="คุณ">คุณ</option>
                            <option value="นาย">นาย</option>
                            <option value="นาง">นาง</option>
                            <option value="นาวสาว">นางสาว</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">ชื่อ</label>
                        <input type="text" class="form-control" name="first_name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">นามสกุล</label>
                        <input type="text" class="form-control" name="last_name" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">เพศ</label>
                        <select class="form-control" name="gender" required>
                            <option value="">-- กรุณาเลือกเพศ --</option>
                            <option value="ชาย">ชาย</option>
                            <option value="หญิง">หญิง</option>
                            <option value="อื่นๆ">อื่นๆ</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">ตำแหน่ง</label>
                        <select class="form-control" name="position" required>
                            <option value="">-- กรุณาเลือกตำแหน่ง --</option>
                            <option value="ผู้จัดการ">ผู้จัดการ</option>
                            <option value="พนักงาน">พนักงาน</option>
                            <option value="หัวหน้าแผนก">หัวหน้าแผนก</option>
                            <option value="เจ้าหน้าที่">เจ้าหน้าที่</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">กลุ่ม</label>
                        <select class="form-control" name="user_group" required>
                            <option value="">-- กรุณาเลือกกลุ่ม --</option>
                            <option value="วิทยาศาสตร์">วิทยาศาสตร์</option>
                            <option value="คณิต">คณิต</option>
                            <option value="ภาษาไทย">ภาษาไทย</option>
                            <option value="อังกฤษ">อังกฤษ</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">วันที่ลง</label>
                        <input type="text" class="form-control" id="registered_at" name="registered_at" required>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>

    <script>
        function formatBuddhistDate(dateObj) {
            const buddhistYear = dateObj.getFullYear() + 543;
            const monthNames = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
            const day = dateObj.getDate();
            return `${day} ${monthNames[dateObj.getMonth()]} ${buddhistYear}`;
        }

        function initThaiDatepicker(selector) {
            flatpickr(selector, {
                dateFormat: "Y-m-d H:i",
                locale: "th",
                altInput: true,
                altFormat: "j M Y H:i",
                allowInput: true,
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

        initThaiDatepicker("#registered_at");
    </script>
@endsection
