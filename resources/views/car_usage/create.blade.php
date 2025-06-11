@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-car me-2"></i>แบบบันทึกการใช้รถราชการ
            </h4>
        </div>

        <div class="mb-4 px-3 mt-3">
            <label for="car_request_id" class="form-label fw-semibold text-muted">
                <i class="bi bi-journal-text me-1"></i>เลือกรายการคำขอ
            </label>
            <select name="car_request_id" id="car_request_id" class="form-select form-select-sm" required>
                <option value="">-- เลือกรายการคำขอ --</option>
                @foreach ($carRequests as $req)
                    <option value="{{ $req->id }}"
                        data-user="{{ $req->user->name ?? '' }}"
                        data-driver="{{ $req->driver }}"
                        data-destination="{{ $req->destination }}"
                        data-start-date="{{ \Carbon\Carbon::parse($req->start_time)->setTimezone('Asia/Bangkok')->format('Y-m-d') }}"
                        data-start-time="{{ \Carbon\Carbon::parse($req->start_time)->setTimezone('Asia/Bangkok')->format('H:i') }}"
                        data-end-date="{{ \Carbon\Carbon::parse($req->end_time)->setTimezone('Asia/Bangkok')->format('Y-m-d') }}"
                        data-end-time="{{ \Carbon\Carbon::parse($req->end_time)->setTimezone('Asia/Bangkok')->format('H:i') }}">
                        [{{ $req->id }}] {{ $req->user->name ?? '' }} ไป {{ $req->destination }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">กรุณาเลือกรายการคำขอ</div>
            <div id="thai-date-info" class="text-muted small fst-italic mt-2"></div>
        </div>

        <div class="card-body">
            <form action="{{ route('car-usage.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="row g-3 mb-4">
                    <div class="col-md-2">
                        <label for="sequence" class="form-label text-muted">
                            <i class="fas fa-list-ol me-1"></i>ลำดับ
                        </label>
                        <input type="number" name="sequence" id="sequence" class="form-control form-control-sm"
                               value="{{ old('sequence', $latestSequence) }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="date" class="form-label text-muted"><i class="far fa-calendar-alt me-1"></i>วันที่ออกเดินทาง</label>
                        <input type="date" name="date" id="date" class="form-control form-control-sm" required readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="time" class="form-label text-muted"><i class="far fa-clock me-1"></i>เวลาไป</label>
                        <input type="time" name="time" id="time" class="form-control form-control-sm" required>
                        <small class="text-muted fst-italic"></small>
                    </div>
                    <div class="col-md-4">
                        <label for="user_name" class="form-label text-muted"><i class="fas fa-user me-1"></i>ผู้ใช้รถ</label>
                        <input type="text" name="user_name" id="user_name" class="form-control form-control-sm" required readonly>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-5">
                        <label for="destination" class="form-label text-muted"><i class="fas fa-map-marker-alt me-1"></i>สถานที่ไป</label>
                        <input type="text" name="destination" id="destination" class="form-control form-control-sm" required readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="start_mileage" class="form-label text-muted"><i class="fas fa-tachometer-alt me-1"></i>เลขไมล์เมื่อออก</label>
                        <div class="input-group input-group-sm">
                            <input type="number" name="start_mileage" id="start_mileage" class="form-control" required>
                            <span class="input-group-text">กม.</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="driver_name" class="form-label text-muted"><i class="fas fa-id-card me-1"></i>พนักงานขับรถ</label>
                        <input type="text" name="driver_name" id="driver_name" class="form-control form-control-sm" required readonly>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="return_date" class="form-label text-muted"><i class="far fa-calendar-check me-1"></i>วันที่กลับ</label>
                        <input type="date" name="return_date" id="return_date" class="form-control form-control-sm" required readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="return_time" class="form-label text-muted"><i class="far fa-clock me-1"></i>เวลากลับ</label>
                        <input type="time" name="return_time" id="return_time" class="form-control form-control-sm" required>
                        <small class="text-muted fst-italic"></small>
                    </div>
                    <div class="col-md-4">
                        <label for="end_mileage" class="form-label text-muted"><i class="fas fa-tachometer-alt me-1"></i>เลขไมล์เมื่อกลับ</label>
                        <div class="input-group input-group-sm">
                            <input type="number" name="end_mileage" id="end_mileage" class="form-control" required>
                            <span class="input-group-text"></span>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label for="total_distance" class="form-label text-muted"><i class="fas fa-road me-1"></i>รวมระยะทาง</label>
                        <div class="input-group input-group-sm">
                            <input type="text" name="total_distance" id="total_distance" class="form-control bg-light" readonly>
                            <span class="input-group-text">กม.</span>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="notes" class="form-label text-muted"><i class="fas fa-edit me-1"></i>หมายเหตุ</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="ระบุหมายเหตุเพิ่มเติม (ถ้ามี)"></textarea>
                </div>

                <input type="hidden" name="car_request_id" id="hidden_car_request_id">

                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-undo me-1"></i>ล้างข้อมูล
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-1"></i>บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const carRequestSelect = document.getElementById('car_request_id');
    const thaiInfo = document.getElementById('thai-date-info');
    const form = document.querySelector('.needs-validation');

    const startMileage = document.getElementById('start_mileage');
    const endMileage = document.getElementById('end_mileage');
    const totalDistance = document.getElementById('total_distance');

    function calculateDistance() {
        const start = parseFloat(startMileage.value) || 0;
        const end = parseFloat(endMileage.value) || 0;
        totalDistance.value = end >= start ? (end - start).toFixed(2) : '0.00';
    }

    startMileage.addEventListener('input', calculateDistance);
    endMileage.addEventListener('input', calculateDistance);

    function formatThaiDate(dateStr) {
        if (!dateStr) return '';
        const months = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
            'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        const [year, month, day] = dateStr.split('-');
        return `${parseInt(day)} ${months[parseInt(month)]} ${parseInt(year) + 543}`;
    }

    if (carRequestSelect) {
        carRequestSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            document.getElementById('user_name').value = selected.getAttribute('data-user') || '';
            document.getElementById('driver_name').value = selected.getAttribute('data-driver') || '';
            document.getElementById('destination').value = selected.getAttribute('data-destination') || '';
            document.getElementById('date').value = selected.getAttribute('data-start-date') || '';
            document.getElementById('time').value = selected.getAttribute('data-start-time') || '';
            document.getElementById('return_date').value = selected.getAttribute('data-end-date') || '';
            document.getElementById('return_time').value = selected.getAttribute('data-end-time') || '';
            document.getElementById('hidden_car_request_id').value = selected.value;

            thaiInfo.innerText =
                `เดินทาง: ${formatThaiDate(selected.getAttribute('data-start-date'))} เวลา ${selected.getAttribute('data-start-time')} | ` +
                `กลับ: ${formatThaiDate(selected.getAttribute('data-end-date'))} เวลา ${selected.getAttribute('data-end-time')}`;
        });
    }

    form.addEventListener('submit', function (event) {
        const timeOut = document.getElementById('time').value;
        const timeBack = document.getElementById('return_time').value;
        const dateOut = document.getElementById('date').value;
        const dateBack = document.getElementById('return_date').value;

        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        } else if (parseFloat(endMileage.value) < parseFloat(startMileage.value)) {
            event.preventDefault();
            alert("เลขไมล์เมื่อกลับต้องมากกว่าหรือเท่ากับเลขไมล์เมื่อออก");
            return;
        } else if (dateOut === dateBack && timeOut && timeBack) {
            const tStart = new Date(`1970-01-01T${timeOut}:00`);
            const tEnd = new Date(`1970-01-01T${timeBack}:00`);
            if (tStart > tEnd) {
                event.preventDefault();
                alert("เวลาไปต้องน้อยกว่าเวลาถึงกลับ (กรณีเดินทางวันเดียวกัน)");
                return;
            }
        }

        form.classList.add('was-validated');
    });
});
</script>
@endpush
