<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function userDashboard()
    {
        $drivers = \App\Models\Driver::all();
        return view('car_requests.calendar', compact('drivers'));
    }


    public function index()
    {
        return redirect()->route('car-requests.calendar');
    }


    //public function chiefDashboard() //ของ chief
    //{
    //    if (Auth::user()->role !== 'chief') {
    //        abort(403);  // ป้องกัน role อื่นเข้า
    //    }

    //    return view('chief.chiefdashboard');  // ✅ ไม่ redirect ซ้ำ
    //}

    //public function driverDashboard() // ของ driver
    //{
    //    if (Auth::user()->role !== 'driver') {
    //        abort(403);
    //    }

    //    return view('driver.driverdashboard');
    //}


    //public function adminDashboard()
    //{
    //    return view('admin.dashboard');  // เปลี่ยนไปตามที่คุณต้องการให้แสดง
    //}
}
