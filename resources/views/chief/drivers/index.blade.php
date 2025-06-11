@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <!-- หัวข้อหน้า -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary fw-bold">
                <i class="fas fa-users-cog me-2"></i>รายชื่อพนักงานขับรถ
            </h3>
            @if (auth()->user()->role === 'chief')
                <a href="{{ route('chief.drivers.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-2"></i>เพิ่มพนักงานขับรถ
                </a>
            @endif
        </div>

        <!-- แจ้งเตือนเมื่อดำเนินการสำเร็จ -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- ตารางแสดงข้อมูล -->
        <div class="card shadow-sm rounded">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-user me-2"></i>ชื่อ</th>
                                <th><i class="fas fa-envelope me-2"></i>อีเมล</th>
                                <th><i class="fas fa-info-circle me-2"></i>สถานะ</th>
                                @if (auth()->user()->role === 'chief')
                                    <th class="text-center"><i class="fas fa-cogs me-2"></i>จัดการ</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($drivers as $driver)
                                <tr>
                                    <td>{{ $driver->name }}</td>
                                    <td>{{ $driver->email }}</td>
                                    <td>
                                        <form action="{{ route('chief.drivers.updateStatus', $driver->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status"
                                                class="border-0 py-1 px-2 rounded-pill text-white fw-bold"
                                                style="background-color:
                                                    {{ $driver->status == 'ว่าง' ? '#28a745' :
                                                    ($driver->status == 'ไม่พร้อม' ? '#dc3545' :
                                                    ($driver->status == 'กำลังปฏิบัติงาน' ? '#ffc107' :
                                                    '#6c757d')) }};
                                                    min-width: 140px; height: 32px;"
                                                onchange="this.form.submit()">
                                                <option value="ว่าง" style="background-color: white; color: black;" {{ $driver->status == 'ว่าง' ? 'selected' : '' }}>ว่าง</option>
                                                <option value="กำลังปฏิบัติงาน" style="background-color: white; color: black;" {{ $driver->status == 'กำลังปฏิบัติงาน' ? 'selected' : '' }}>กำลังปฏิบัติงาน</option>
                                                <option value="ไม่พร้อม" style="background-color: white; color: black;" {{ $driver->status == 'ไม่พร้อม' ? 'selected' : '' }}>ไม่พร้อม</option>
                                                <option value="ลาพัก" style="background-color: white; color: black;" {{ $driver->status == 'ลาพัก' ? 'selected' : '' }}>ลาพัก</option>
                                            </select>
                                        </form>
                                    </td>
                                    @if (auth()->user()->role === 'chief')
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('chief.drivers.edit', $driver->id) }}"
                                                    class="btn btn-sm btn-warning" data-bs-toggle="tooltip" title="แก้ไขข้อมูล">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('chief.drivers.destroy', $driver->id) }}" method="POST"
                                                    style="display:inline-block;"
                                                    onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบพนักงานคนนี้?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="tooltip" title="ลบพนักงาน">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- แสดงข้อความเมื่อไม่มีข้อมูล -->
        @if ($drivers->isEmpty())
            <div class="alert alert-info mt-4 text-center">
                <i class="fas fa-info-circle me-2"></i>ยังไม่มีข้อมูลพนักงานขับรถ
            </div>
        @endif
    </div>

@section('scripts')
    <script>
        // เปิดใช้งาน Tooltip
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endsection
@endsection
