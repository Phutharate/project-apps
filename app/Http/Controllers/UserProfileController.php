<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;

class UserProfileController extends Controller
{
    public function index()
    {
        $users = UserProfile::all();
        return view('user_profiles.index', compact('users'));
    }

    public function create()
    {
        return view('user_profiles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'prefix' => 'required|string|max:10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:ชาย,หญิง',
            'position' => 'required|string|max:255',
            'user_group' => 'required|string|max:255',
            'registered_at' => 'required|date',
            'role' => 'required|in:user,chief,admin', // เพิ่ม role validation
        ]);

        UserProfile::create($request->all());

        return redirect()->route('user-profiles.index')->with('success', 'เพิ่มผู้ใช้เรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $user = UserProfile::findOrFail($id);
        return view('user_profiles.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'prefix' => 'required|string|max:10',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:ชาย,หญิง',
            'position' => 'required|string|max:255',
            'user_group' => 'required|string|max:255',
            'registered_at' => 'required|date',
            'role' => 'required|in:user,chief,admin', // เพิ่ม role validation
        ]);

        $user = UserProfile::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('user-profiles.index')->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $user = UserProfile::findOrFail($id);
        $user->delete();

        return redirect()->route('user-profiles.index')->with('success', 'ลบผู้ใช้เรียบร้อยแล้ว');
    }
}
