@extends('layouts.app') {{-- หรือ layouts.main ถ้าคุณใช้ layout อื่น --}}

@section('content')
    <h2>จัดการผู้ใช้งาน</h2>
    @livewire('user-form')
@endsection