<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarRequest;
use App\Notifications\CarRequestAssignedToDriver;
use App\Notifications\CarRequestReviewed;
use App\Models\User;

class CarApprovalController extends Controller
{
    public function pending()
    {
        $requests = CarRequest::where('status', 'pending')->get(); //กรองแบบเฉพาะที่ chief ดูแล
        return view('chief.car_requests.pending', compact('requests'));
    }

    public function approved()
    {
        $requests = \App\Models\CarRequest::where('status', 'approved')->get();
        return view('chief.car_requests.approved', compact('requests'));
    }

    public function rejected()
    {
        $requests = CarRequest::where('status', 'rejected')->get();
        return view('chief.car_requests.rejected', compact('requests'));
    }

    public function acknowledgementHistory()
    {
        $requests = \App\Models\CarRequest::orderBy('acknowledged_at', 'desc')->paginate(20);
        return view('chief.acknowledgement_history', compact('requests'));
    }




    public function Chiefapprove($id)
    {
        $req = CarRequest::findOrFail($id);
        $req->status = 'approved';
        $req->save();

        $req->user->notify(new CarRequestReviewed($req)); // แจ้งเตือนเจ้าของคำขอ

        //แจ้งเตือนคนขับ
        $driverName = $req->driver;
        $driverUser = User::where('name', $driverName)->first();

        if ($driverUser) {
            $driverUser->notify(new CarRequestAssignedToDriver($req));
        }

        return back()->with('success', 'อนุมัติคำขอเรียบร้อยแล้ว');
    }

    public function Chiefreject($id)
    {
        $req = CarRequest::findOrFail($id);
        $req->status = 'rejected';
        $req->save();

        $req->user->notify(new CarRequestReviewed($req)); // แจ้งเตือนเจ้าของคำขอ

        return back()->with('success', 'ไม่อนุมัติคำขอ');
    }
}
