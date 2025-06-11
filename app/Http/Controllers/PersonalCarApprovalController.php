<?php

namespace App\Http\Controllers;

use App\Models\PersonalCarRequest;
use Illuminate\Http\Request;

class PersonalCarApprovalController extends Controller
{
    public function pending()
    {
        $requests = PersonalCarRequest::where('status', 'pending')->get();
        return view('chief.personal_requests.pending', compact('requests'));
    }

    public function approved()
    {
        $requests = PersonalCarRequest::where('status', 'approved')->get();
        return view('chief.personal_requests.approved', compact('requests'));
    }

    public function rejected()
    {
        $requests = PersonalCarRequest::where('status', 'rejected')->get();
        return view('chief.personal_requests.rejected', compact('requests'));
    }

    public function approve($id)
    {
        $req = PersonalCarRequest::findOrFail($id);
        $req->status = 'approved';
        $req->save();

        return back()->with('success', 'อนุมัติคำขอแล้ว');
    }

    public function reject($id)
    {
        $req = PersonalCarRequest::findOrFail($id);
        $req->status = 'rejected';
        $req->save();

        return back()->with('success', 'ไม่อนุมัติคำขอ');
    }
}
