@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">📋 งานที่ได้รับมอบหมาย</h2>

    <!-- 🔍 ฟอร์มค้นหาตามเดือน -->
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="month" id="monthInput" class="form-control"
                   value="{{ request('month') ?? now()->format('Y-m') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary">🔍 ค้นหา</button>
        </div>
    </form>

    <!-- ℙ️ แสดงเดือนที่กรอง -->
    @if (request('month'))
        @php
            try {
                $carbonMonth = \Carbon\Carbon::createFromFormat('Y-m', request('month'));
                $carbonMonth->locale('th');
                $monthName = $carbonMonth->translatedFormat('F');
                $buddhistYear = $carbonMonth->year + 543;
            } catch (Exception $e) {
                $monthName = null;
                $buddhistYear = null;
            }
        @endphp
        @if ($monthName && $buddhistYear)
            <p class="text-muted mb-4"> กำลังแสดงงานของเดือน {{ $monthName }} {{ $buddhistYear }} </p>
        @endif
    @endif

    @if ($requests->isEmpty())
        <div class="alert alert-info text-center">
            ยังไม่มีงานที่ได้รับมอบหมายในเดือนนี้
        </div>
    @else
        <!-- 🔍 ช่องค้นหา -->
        <div class="mb-4">
            <input type="text" id="jobSearch" class="form-control"
                   placeholder="🔍 ค้นหาสถานที่, วัตถุประสงค์ หรือชื่อผู้ขอ...">
        </div>

        <div class="row row-cols-1 row-cols-md-2 g-4" id="jobCards">
            @foreach ($requests as $request)
                @php
                    $driverUser = \App\Models\User::where('name', $request->driver)->first();
                @endphp

                <div class="col job-card">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5>📞 งานวันที่ {{ \Carbon\Carbon::parse($request->start_time)->format('d/m/Y') }}</h5>
                                <span class="badge bg-info text-dark">
                                    {{ \Carbon\Carbon::parse($request->start_time)->format('d M Y H:i') }}
                                </span>
                            </div>

                            <p class="mb-2"><strong>📍 สถานที่:</strong> {{ $request->destination }}</p>

                            <ul class="list-unstyled small mb-0">
                                <li><strong>🔑 รหัสคนขับ:</strong> {{ $driverUser->code ?? '-' }}</li>
                                <li><strong>👤 ผู้ขอ:</strong> {{ $request->name }}</li>
                                <li><strong>📞 เบอร์ผู้ขอ:</strong> {{ $request->requester_phone ?? '-' }}</li>
                                <li><strong>📝 เรื่อง:</strong> {{ $request->purpose }}</li>
                                <li><strong>🕒 เวลาประชุม:</strong>
                                    {{ \Carbon\Carbon::parse($request->meeting_datetime)->format('d/m/Y H:i') }}</li>
                                <li><strong>🢑 จำนวนคนนั่ง:</strong> {{ $request->seats }} คน</li>
                                <li><strong>🚗 รถ:</strong> {{ $request->car_name }}</li>
                                <li><strong>📄 ทะเบียน:</strong> {{ $request->car_registration ?? '-' }}</li>
                                <li><strong>👨‍✈️ คนขับ:</strong> {{ $request->driver }}</li>
                                <li><strong>🧽 จังหวัด:</strong> {{ $request->province }}</li>
                                <li><strong>🗓️ ไป-กลับ:</strong>
                                    {{ \Carbon\Carbon::parse($request->start_time)->format('d/m/Y H:i') }}
                                    ถึง
                                    {{ \Carbon\Carbon::parse($request->end_time)->format('d/m/Y H:i') }}
                                </li>
                            </ul>

                            <hr>
                            @if ($request->acknowledgement_status === 'none')
                                <form method="POST" action="{{ route('driver.acknowledge', $request->id) }}">
                                    @csrf
                                    <div class="d-flex gap-2">
                                        <button name="status" value="accepted" class="btn btn-success btn-sm">✅ รับทราบ</button>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="document.getElementById('rejectForm-{{ $request->id }}').style.display='block'">❌ ไม่รับทราบ</button>
                                    </div>
                                </form>

                                <form id="rejectForm-{{ $request->id }}" style="display:none;" method="POST"
                                    action="{{ route('driver.acknowledge', $request->id) }}">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <div class="mt-2">
                                        <textarea name="reason" class="form-control form-control-sm" placeholder="กรุณาระบุเหตุผล..." required></textarea>
                                        <button type="submit" class="btn btn-danger btn-sm mt-2">ส่งเหตุผล</button>
                                    </div>
                                </form>
                            @elseif ($request->acknowledgement_status === 'accepted')
                                <div class="alert alert-success mt-3 p-2">✅ รับทราบแล้วเมื่อ
                                    {{ \Carbon\Carbon::parse($request->acknowledged_at)->format('d/m/Y H:i') }}</div>
                            @elseif ($request->acknowledgement_status === 'rejected')
                                <div class="alert alert-danger mt-3 p-2">
                                    ❌ ไม่รับทราบ<br>
                                    <strong>เหตุผล:</strong> {{ $request->acknowledgement_reason }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/th.js"></script>

<script>
    flatpickr("#monthInput", {
        locale: "th",
        disableMobile: true,
        altInput: true,
        dateFormat: "Y-m",
        plugins: [
            new monthSelectPlugin({
                shorthand: false,
                dateFormat: "Y-m",
                altFormat: "F Y",
                theme: "light"
            })
        ],
        onReady: function (selectedDates, dateStr, instance) {
            convertToBuddhistYear(instance);
        },
        onChange: function (selectedDates, dateStr, instance) {
            convertToBuddhistYear(instance);
        }
    });

    function convertToBuddhistYear(instance) {
        if (!instance.altInput || !instance.selectedDates.length) return;

        const date = instance.selectedDates[0];
        const buddhistYear = date.getFullYear() + 543;
        const monthName = date.toLocaleString('th-TH', { month: 'long' });

        instance.altInput.value = `${monthName} ${buddhistYear}`;
    }

    document.getElementById('jobSearch').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('.job-card').forEach(card => {
            const text = card.innerText.toLowerCase();
            card.style.display = text.includes(keyword) ? 'block' : 'none';
        });
    });
</script>
@endpush
