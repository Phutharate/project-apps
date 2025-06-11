<?php

namespace App\Http\Controllers;

use App\Models\FuelUsage;
use Illuminate\Http\Request;
use App\Models\CarUsage;

class FuelUsageController extends Controller
{
    public function index()
    {
        $usages = FuelUsage::all();
        return view('fuel.index', compact('usages'));
    }

    public function create()
    {
        $latestUsage = \App\Models\CarUsage::latest()->first();

        $initialMileage = $latestUsage?->start_mileage ?? '';
        $distance = $latestUsage?->total_distance ?? '';

        // ✅ เพิ่มการคำนวณน้ำมันและเงิน
        $fuelLiters = '';
        $amount_baht = '';

        if (is_numeric($distance) && $distance > 0) {
            $fuelLiters = round($distance * 0.0833, 2); // ประมาณ 12 กม./ลิตร
            $amount_baht = round($fuelLiters * 35, 2); // ราคาน้ำมัน 35 บาท/ลิตร
        }

        return view('fuel.create', compact('initialMileage', 'distance', 'fuelLiters', 'amount_baht'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'license_plate' => 'required',
            // เพิ่มการตรวจสอบอื่น ๆ ตามความเหมาะสม
        ]);

        FuelUsage::create($request->all());

        return redirect()->route('fuel.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }
}
