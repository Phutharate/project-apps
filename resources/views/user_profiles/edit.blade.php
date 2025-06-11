@extends('layouts.app')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)  {{-- เอาไว้แสดงError --}}
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-warning text-white">แก้ไขข้อมูลผู้ใช้</div>
            <div class="card-body">
                <form action="{{ route('user-profiles.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">สิทธิ์ผู้ใช้ (Role)</label>
                        <select class="form-control" name="role" required>
                            @foreach (['user' => 'User', 'chief' => 'Chief', 'admin' => 'Admin'] as $value => $label)
                                <option value="{{ $value }}" {{ $user->role == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">คำนำหน้า</label>
                        <select class="form-control" name="prefix" required>
                            <option value="">-- กรุณาเลือกคำนำหน้า --</option>
                            @foreach (['คุณ', 'นาย', 'นาง', 'นางสาว'] as $prefix)
                                <option value="{{ $prefix }}" {{ $user->prefix == $prefix ? 'selected' : '' }}>
                                    {{ $prefix }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ชื่อ</label>
                        <input type="text" class="form-control" name="first_name"
                            value="{{ old('first_name', $user->first_name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">นามสกุล</label>
                        <input type="text" class="form-control" name="last_name"
                            value="{{ old('last_name', $user->last_name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">เพศ</label>
                        <select class="form-control" name="gender" required>
                            <option value="">-- กรุณาเลือกเพศ --</option>
                            @foreach (['ชาย', 'หญิง', 'อื่นๆ'] as $gender)
                                <option value="{{ $gender }}" {{ $user->gender == $gender ? 'selected' : '' }}>
                                    {{ $gender }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ตำแหน่ง</label>
                        <select class="form-control" name="position" required>
                            @foreach (['ผู้จัดการ', 'พนักงาน', 'หัวหน้าแผนก', 'เจ้าหน้าที่'] as $position)
                                <option value="{{ $position }}" {{ $user->position == $position ? 'selected' : '' }}>
                                    {{ $position }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">กลุ่ม</label>
                        <select class="form-control" name="user_group" required>
                            @foreach (['วิทยาศาสตร์', 'คณิต', 'ภาษาไทย', 'อังกฤษ'] as $group)
                                <option value="{{ $group }}" {{ $user->user_group == $group ? 'selected' : '' }}>
                                    {{ $group }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">วันที่ลง</label>
                        <input type="date" class="form-control" name="registered_at"
                            value="{{ old('registered_at', $user->registered_at) }}" required>
                    </div>

                    <button type="submit" class="btn btn-success">อัปเดต</button>
                </form>
            </div>
        </div>
    </div>
@endsection
