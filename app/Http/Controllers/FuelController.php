<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fuel;

class FuelController extends Controller
{
    /**
     * แสดงรายการบันทึกการใช้น้ำมันทั้งหมด
     */
    public function index()
    {
        $fuels = Fuel::orderBy('date', 'desc')->paginate(10);
        return view('fuel.index', compact('fuels'));
    }

    /**
     * แสดงฟอร์มสำหรับสร้างรายการใหม่
     */
    public function create()
    {
        return view('fuel.create');
    }

    /**
     * บันทึกข้อมูลใหม่ลงฐานข้อมูล
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'license_plate' => 'nullable|string|max:20',
            'start_km' => 'nullable|integer',
            'distance' => 'nullable|integer',
            'fuel_liters' => 'nullable|numeric',
            'amount_spent' => 'nullable|numeric',
            'issued_by' => 'nullable|string|max:100',
            'receiver' => 'nullable|string|max:100',
            'remark' => 'nullable|string',
        ]);

        $fuel = new Fuel();
        $fuel->date = $request->date;
        $fuel->fuel_order_number = $request->fuel_order_number[0] ?? null;
        $fuel->receipt_number = $request->receipt_number[0] ?? null;
        $fuel->license_plate = $request->license_plate;
        $fuel->start_km = $request->start_km;
        $fuel->distance = $request->distance;
        $fuel->fuel_liters = $request->fuel_liters;
        $fuel->amount_spent = $request->amount_spent;
        $fuel->issued_by = $request->issued_by;
        $fuel->receiver = $request->receiver;
        $fuel->remark = $request->remark;
        $fuel->save();

        return redirect()->route('fuel.index')->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    /**
     * แสดงฟอร์มสำหรับแก้ไขรายการ
     */
    public function edit($id)
    {
        $fuel = Fuel::findOrFail($id);
        return view('fuel.edit', compact('fuel'));
    }

    /**
     * อัปเดตรายการในฐานข้อมูล
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'license_plate' => 'nullable|string|max:20',
            'start_km' => 'nullable|integer',
            'distance' => 'nullable|integer',
            'fuel_liters' => 'nullable|numeric',
            'amount_spent' => 'nullable|numeric',
            'issued_by' => 'nullable|string|max:100',
            'receiver' => 'nullable|string|max:100',
            'remark' => 'nullable|string',
        ]);

        $fuel = Fuel::findOrFail($id);
        $fuel->date = $request->date;
        $fuel->fuel_order_number = $request->fuel_order_number[0] ?? null;
        $fuel->receipt_number = $request->receipt_number[0] ?? null;
        $fuel->license_plate = $request->license_plate;
        $fuel->start_km = $request->start_km;
        $fuel->distance = $request->distance;
        $fuel->fuel_liters = $request->fuel_liters;
        $fuel->amount_spent = $request->amount_spent;
        $fuel->issued_by = $request->issued_by;
        $fuel->receiver = $request->receiver;
        $fuel->remark = $request->remark;
        $fuel->save();

        return redirect()->route('fuel.index')->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
    }

    /**
     * ลบรายการออกจากฐานข้อมูล
     */
    public function destroy($id)
    {
        $fuel = Fuel::findOrFail($id);
        $fuel->delete();

        return redirect()->route('fuel.index')->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
