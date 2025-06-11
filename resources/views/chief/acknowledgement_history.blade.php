@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-primary fw-bold">
            📝 รายการที่คนขับกดรับทราบ/ไม่รับทราบ
        </h2>

        @if ($requests->isEmpty())
            <div class="alert alert-info text-center">
                ยังไม่มีรายการรับทราบจากคนขับ
            </div>
        @else
            
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-light text-center align-middle">
                        <tr>
                            <th class="text-nowrap">📅 วันที่เดินทาง</th>
                            <th class="text-nowrap">🧍‍♂️ คนขับ</th>
                            <th class="text-nowrap">🚗 รถ</th>
                            <th class="text-nowrap">🎯 วัตถุประสงค์</th>
                            <th class="text-nowrap">📢 สถานะตอบกลับ</th>
                            <th class="text-nowrap">📄 เหตุผล</th>
                            <th class="text-nowrap">⏱ เวลารับทราบ</th>
                            <th class="text-nowrap">🔍 ดูเพิ่มเติม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $request)
                            <tr>
                                <!-- วันที่ -->
                                <td class="text-nowrap">
                                    {{ \Carbon\Carbon::parse($request->start_time)->timezone('Asia/Bangkok')->format('d/m/Y H:i') }}
                                </td>

                                <!-- คนขับ -->
                                <td class="text-nowrap">{{ $request->driver }}</td>

                                <!-- รถ -->
                                <td class="text-nowrap">
                                    {{ $request->car_name }}<br>
                                    <small class="text-muted">{{ $request->car_registration }}</small>
                                </td>

                                <!-- วัตถุประสงค์ -->
                                <td class="text-nowrap">{{ $request->purpose }}</td>

                                <!-- สถานะตอบกลับ -->
                                <td class="text-nowrap">
                                    @if ($request->acknowledgement_status === 'accepted')
                                        <span class="badge bg-success">✅ รับทราบ</span>
                                    @elseif ($request->acknowledgement_status === 'rejected')
                                        <span class="badge bg-danger">❌ ไม่รับทราบ</span>
                                    @else
                                        <span class="badge bg-secondary">⏳ ยังไม่ตอบ</span>
                                    @endif
                                </td>

                                <!-- เหตุผล -->
                                <td class="text-nowrap">{{ $request->acknowledgement_reason ?? '-' }}</td>

                                <!-- เวลารับทราบ -->
                                <td class="text-nowrap">
                                    @if ($request->acknowledged_at)
                                        <span class="badge rounded-pill bg-light border text-dark">
                                            🕒
                                            {{ \Carbon\Carbon::parse($request->acknowledged_at)->timezone('Asia/Bangkok')->format('d/m/Y H:i') }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <!-- ดูเพิ่มเติม -->
                                <td class="text-nowrap">
                                    <a href="{{ route('car-requests.show', $request->id) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-search"></i> ดู
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        @endif
    </div>
@endsection
