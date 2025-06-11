<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;
use App\Models\User;


class ChiefDriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        return view('chief.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('chief.drivers.create');
    }



public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
        'status' => 'required|string',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'driver',
        'status' => $request->status,
    ]);

    // สร้าง Driver ที่เกี่ยวข้อง
    Driver::create([
        'name' => $request->name,
        'email' => $request->email,
        'status' => $request->status,
        'user_id' => $user->id, // ควรมีฟิลด์นี้ในตาราง drivers
    ]);

    return redirect()->route('chief.drivers.index')->with('success', 'เพิ่มพนักงานขับรถเรียบร้อยแล้ว');
}


    public function edit(Driver $driver)
    {
        return view('chief.drivers.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $driver->user_id, // ควรใช้ user_id ถ้ามี
        'status' => 'required',
    ]);

    // อัปเดต Driver
    $driver->update([
        'name' => $request->name,
        'email' => $request->email,
        'status' => $request->status,
    ]);

    // อัปเดต User ที่เกี่ยวข้อง
    $user = User::where('email', $driver->getOriginal('email'))->first();
    if ($user) {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);
    }

    return redirect()->route('chief.drivers.index')->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
}

    public function destroy(Driver $driver)
{
    if ($driver->user_id) {
        User::find($driver->user_id)?->delete();
    }

    $driver->delete();

    return redirect()->route('chief.drivers.index')->with('success', 'ลบข้อมูลพนักงานเรียบร้อยแล้ว');
}



    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|string',
    ]);

    $driver = Driver::findOrFail($id);
    $driver->status = $request->status;
    $driver->save();

    return redirect()->back()->with('success', 'อัปเดตสถานะเรียบร้อยแล้ว');
}

    
}
