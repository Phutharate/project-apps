<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChiefDashboardController extends Controller
{
    public function chiefDashboard() //ของ chief
    {
        if (Auth::user()->role !== 'chief') {
            abort(403);  // ป้องกัน role อื่นเข้า
        }

        return view('chief.chiefdashboard');  // ✅ ไม่ redirect ซ้ำ
    }
}
