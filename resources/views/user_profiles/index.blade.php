@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header bg-info text-white">รายการผู้ใช้</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>คำนำหน้า</th>
                            <th>ชื่อ</th>
                            <th>นามสกุล</th>
                            <th>เพศ</th>
                            <th>ตำแหน่ง</th>
                            <th>กลุ่ม</th>
                            <th>วันที่ลง</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->prefix }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->gender }}</td>
                                <td>{{ $user->position }}</td>
                                <td>{{ $user->user_group }}</td>
                                <td>{{ date('d/m/Y', strtotime($user->registered_at)) }}</td>
                                <td>

                                    <a href="{{ route('user-profiles.edit', $user->id) }}" class="btn btn-sm btn-warning">แก้ไข</a>

                                    <form action="{{ route('user-profiles.destroy', $user->id) }}" method="POST"
                                        style="display:inline-block;"
                                        onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบผู้ใช้นี้?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
