@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- 🟦 ปฏิทิน -->
            <div class="col-md-9 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">📅 ปฏิทินกิจกรรม</h3>
                    </div>
                    <div class="card-body">
                        <div id="calendar" style="min-height: 600px;"></div>
                    </div>
                </div>
            </div>

           <!-- 👨‍✈️ รายชื่อคนขับ -->
<div class="col-md-3 mb-4">
    <div class="card border-secondary">
        <div class="card-header bg-secondary text-white fw-bold">
            👨‍✈️ รายชื่อคนขับรถ
        </div>
        <ul class="list-group list-group-flush driver-scroll">
            @foreach ($drivers ?? [] as $driver)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $driver->name }}
                    @php
                        $status = $driver->status;
                        $badgeClass = match ($status) {
                            'ว่าง' => 'success',
                            'กำลังปฏิบัติงาน' => 'primary',
                            'ลาพัก' => 'warning',
                            'ไม่พร้อม' => 'danger',
                            default => 'secondary',
                        };
                        $statusEmoji = match ($status) {
                            'ว่าง' => '✅',
                            'กำลังปฏิบัติงาน' => '🚗',
                            'ลาพัก' => '🌴',
                            'ไม่พร้อม' => '❌',
                            default => '❓',
                        };
                    @endphp
                    <span class="badge bg-{{ $badgeClass }}">
                        {{ $statusEmoji }} {{ $status }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- 🔄 แยก card ปรับสถานะออกนอก ul -->
    @auth
    @if(auth()->user()->role === 'chief')
        <!-- 🔄 แยก card ปรับสถานะออกนอก ul -->
        <div class="card mt-3">
            <div class="card-header bg-dark text-white fw-bold">
                🔄 ปรับสถานะคนขับ
            </div>
            <div class="card-body">
                @foreach ($drivers ?? [] as $driver)
                    <div class="mb-3">
                        <div class="fw-bold mb-1">{{ $driver->name }}</div>
                        <div class="btn-group" role="group" aria-label="เปลี่ยนสถานะ">
                            @foreach (['ว่าง' => 'success', 'กำลังปฏิบัติงาน' => 'primary', 'ไม่พร้อม' => 'danger', 'ลาพัก' => 'warning'] as $status => $color)
                                <form method="POST" action="{{ route('chief.drivers.updateStatus', $driver->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $status }}">
                                    <button type="submit" class="btn btn-outline-{{ $color }} btn-sm">
                                        @switch($status)
                                            @case('ว่าง') ✅ @break
                                            @case('กำลังปฏิบัติงาน') 🚗 @break
                                            @case('ไม่พร้อม') ❌ @break
                                            @case('ลาพัก') 🌴 @break
                                        @endswitch
                                        {{ $status }}
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.css" rel="stylesheet">
    <style>
        .list-group-item {
            font-size: 0.9rem;
        }

        .driver-scroll {
            max-height: 450px;
            overflow-y: auto;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'th',
                timeZone: 'local',
                events: '/car-requests/calendar-events',

                eventContent: function(arg) {
                    const event = arg.event.extendedProps;
                    const bgColor = arg.event.backgroundColor || '#3788d8';
                    return {
                        html: `
                        <div style="
                            font-size: 0.75rem;
                            line-height: 1.2;
                            background-color: ${bgColor};
                            color: #fff;
                            padding: 2px 4px;
                            border-radius: 3px;
                        ">
                            <b>สถานที่: ${arg.event.title}</b><br>
                            ผู้ขอ: ${event.requester}<br>
                            กลุ่ม: ${event.department}<br>
                            เวลา: ${event.start_time} - ${event.end_time}<br>
                            ทะเบียนรถ: ${event.car_registration ?? '-'}
                        </div>
                    `
                    };
                },

                eventClick: function(info) {
                    const props = info.event.extendedProps;

                    document.getElementById('modal-destination').textContent = info.event.title;
                    document.getElementById('modal-requester').textContent = props.requester;
                    document.getElementById('modal-department').textContent = props.department;
                    document.getElementById('modal-time').textContent =
                        `${props.start_time} - ${props.end_time}`;
                    document.getElementById('modal-plate').textContent = props.car_registration;
                    document.getElementById('modal-driver').textContent = props.driver ?? '-';
                    document.getElementById('modal-purpose').textContent = props.purpose ?? '-';
                    document.getElementById('modal-meeting_datetime').textContent = props
                        .meeting_datetime ?? '-';
                    document.getElementById('modal-province').textContent = props.province ?? '-';
                    document.getElementById('modal-car_name').textContent = props.car_name ?? '-';
                    document.getElementById('modal-driver_phone').textContent = props.driver_phone ??
                        '-';
                    document.getElementById('modal-car_request_time').textContent = props
                        .request_time ?? '-';

                    new bootstrap.Modal(document.getElementById('eventDetailModal')).show();
                },

                dateClick: function(info) {
                    fetch('/car-requests/set-date', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            date: info.dateStr
                        })
                    }).then(() => {
                        window.location.href = '/car-requests/create';
                    });
                }
            });

            calendar.render();
        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="eventDetailModalLabel">รายละเอียด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>สถานที่:</strong> <span id="modal-destination"></span></p>
                    <p><strong>เพื่อ(ไปทำอะไร):</strong> <span id="modal-purpose"></span></p>
                    <p><strong>เวลาที่ประชุม:</strong> <span id="modal-meeting_datetime"></span></p>
                    <p><strong>จังหวัด:</strong> <span id="modal-province"></span></p>
                    <p><strong>ผู้ขอ:</strong> <span id="modal-requester"></span></p>
                    <p><strong>กลุ่ม:</strong> <span id="modal-department"></span></p>
                    <p><strong>เวลาไป/กลับ:</strong> <span id="modal-time"></span></p>
                    <p><strong>ทะเบียนรถ:</strong> <span id="modal-plate"></span></p>
                    <p><strong>รถ:</strong> <span id="modal-car_name"></span></p>
                    <p><strong>คนขับ:</strong> <span id="modal-driver"></span></p>
                    <p><strong>เบอร์คนขับ:</strong> <span id="modal-driver_phone"></span></p>
                    <p><strong>เวลาที่ขอรถ:</strong> <span id="modal-car_request_time"></span></p>
                </div>
            </div>
        </div>
    </div>
@endpush
