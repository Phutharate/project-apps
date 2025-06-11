<?php

namespace App\Http\Controllers;

use App\Models\CarRequest;
use App\Notifications\CarRequestReviewed;
use App\Notifications\CarRequestSubmitted;
use App\Notifications\NotifyDirectorOfCarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\TelegramCarRequestNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DriverAcknowledgedNotification;
use App\Models\Driver;
use App\Models\Car;

use Mpdf\Mpdf;
use NotificationChannels\Telegram\Telegram;

class CarRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function approve($id)
    {
        $request = CarRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();

        return redirect()->back()->with('success', 'อนุมัติเรียบร้อย');
    }

    //public function reject(CarRequest $carRequest)
    //{
    //    $carRequest->update(['status'=>'rejected']);
    //    return back()->with('error','ไม่อนุมัติ');
    //}


    public function index(Request $request)
    {
        $user = Auth::user();
        $query = CarRequest::query();

        if ($user->role === 'driver') {
            $query->where('driver', $user->name);
        } elseif (!in_array($user->role, ['chief', 'director'])) {
            $query->where('user_id', $user->id);
        }

        // ✅ เพิ่มการกรองตามเดือน
        if ($request->filled('month')) {
            try {
                $month = \Carbon\Carbon::createFromFormat('Y-m', $request->month);
                $query->whereMonth('start_time', $month->month)
                    ->whereYear('start_time', $month->year);
            } catch (\Exception $e) {
                // ไม่ทำอะไร ถ้าเดือนผิด
            }
        }

        $requests = $query->latest()->get();

        return view('car_requests.list', compact('requests'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $defaultDate = session('car_request_date', null);
        return view('car_requests.form', compact('defaultDate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_image' => 'required|string',
            'name' => 'required|string',
            'position' => 'required|string',
            'department' => 'required|string',
            'requester_phone' => 'nullable|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'destination' => 'required|string',
            'seats' => 'required|numeric|min:1|max:99',
            'car_registration' => 'required|string',
            'driver' => 'required|string',
            'driver_phone' => 'nullable|string|max:255',
            'reason' => 'nullable|string',
            'purpose' => 'nullable|string',
            'car_name' => 'nullable|string',     // เปลี่ยนจาก car_id เป็น car_name และใช้ string เพราะเป็นชื่อรถ
            'meeting_datetime' => 'nullable|date',
            'car_request_time' => 'nullable|string',
            'province' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $validated['user_id'] = Auth::id();

        // ✅ บันทึก path ไฟล์แนบไว้ใน validated ก่อน
        if ($request->hasFile('attachment')) {
            $filename = time() . '_' . $request->file('attachment')->getClientOriginalName();
            $filePath = $request->file('attachment')->storeAs('attachments', $filename, 'public');
            $validated['attachment_path'] = $filePath;
        }


        // สร้างคำขอใหม่และเก็บผลลัพธ์ในตัวแปร $carRequest
        $carRequest = CarRequest::create($validated);

        // 🔔 ส่งแจ้งเตือนไปยัง Chief
        $chief = User::where('role', 'chief')->first();
        $chief->notify(new CarRequestSubmitted($carRequest));

        // 🔔 ส่งแจ้งเตือนไปยังผู้ใช้เจ้าของคำขอ
        $carRequest->user->notify(new CarRequestReviewed($carRequest));

        // ✅ 🔔 ส่งแจ้งเตือนไปยัง Director
        $directors = User::where('role', 'director')->get();
        Notification::send($directors, new NotifyDirectorOfCarRequest($carRequest));

        return redirect()->route('car-requests.create')->with('success', 'ส่งคำขอเรียบร้อย');

        // Notification::route('telegram', 'YOUR_TELEGRAM_CHAT_ID')
        //    ->notify(new TelegramCarRequestNotification($carRequest));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();

        if (in_array($user->role, ['chief', 'director'])) {
            // เห็นทุกคำขอ
            $request = CarRequest::findOrFail($id);
        } elseif ($user->role === 'driver') {
            // เห็นเฉพาะคำขอที่ชื่อคนขับตรงกับตนเอง
            $request = CarRequest::where('id', $id)
                ->where('driver', $user->name)
                ->firstOrFail();
        } else {
            // เห็นเฉพาะคำขอที่ตนเองเป็นผู้สร้าง
            $request = CarRequest::where('id', $id)
                ->where('user_id', $user->id)
                ->firstOrFail();
        }

        return view('car_requests.show', compact('request'));
    }


    // public function calendar()
    // {
    //    $drivers = Driver::all();
    //     return view('car_requests.calendar', compact('drivers'));
    // }

    // แสดงข้อมูลทั้งหมดในปฏิทิน
    public function calendarEvents()
    {
        $requests = CarRequest::all();  //('user_id', auth::id())->get();

        $events = [];

        foreach ($requests as $request) {
            $events[] = [
                'title' => $request->destination,
                'start' => $request->start_time,
                'end' => $request->end_time,
                'backgroundColor' => '#1e90ff',
                'extendedProps' => [
                    'requester' => $request->name,
                    'department' => $request->department,
                    'car_registration' => $request->car_registration,
                    'driver' => $request->driver,
                    'driver_phone' => $request->driver_phone ?? '-',
                    'start_time' => date('d/m/Y H:i', strtotime($request->start_time)),
                    'end_time' => date('d/m/Y H:i', strtotime($request->end_time)),
                    'purpose' => $request->purpose,
                    'meeting_datetime' => date('d/m/Y H:i', strtotime($request->meeting_datetime)),
                    'province' => $request->province,
                    'car_name' => $request->car_name,
                    'request_time' => date('d/m/Y H:i', strtotime($request->car_request_time)),

                ],
            ];
        }

        return response()->json($events);
    }

    public function calendar()
    {
        $drivers = Driver::all(); // ดึงข้อมูลคนขับทั้งหมด
        return view('car_requests.calendar', compact('drivers'));
    }




    public function printFome($id)
    {
        $request = CarRequest::findOrFail($id);

        // สร้าง PDF และส่งไปที่ browser
        $pdf = Pdf::loadView('requests.print', compact('request'));

        return $pdf->stream('car_request_print');
    }

    //สำหรับ แจ้งรับทราบหรือไม่รับทราบ
    public function acknowledge(Request $request, $id)
    {
        $carRequest = \App\Models\CarRequest::findOrFail($id);

        $status = $request->input('status');
        if (!in_array($status, ['accepted', 'rejected'])) {
            return back()->with('error', 'สถานะไม่ถูกต้อง');
        }

        $carRequest->acknowledgement_status = $status;
        $carRequest->acknowledgement_reason = $status === 'rejected' ? $request->input('reason') : null;
        $carRequest->acknowledged_at = now();
        $carRequest->save();

        // 🔔 แจ้ง Chief ทุกคน
        $chiefs = \App\Models\User::where('role', 'chief')->get();   // ใช้ Spatie หรือเปลี่ยนเป็น filter ตาม group ก็ได้
        Notification::send($chiefs, new DriverAcknowledgedNotification($carRequest));

        return back()->with('success', 'บันทึกการตอบกลับเรียบร้อยแล้ว');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function printForm($id)
    {
        $request = CarRequest::findOrFail($id);

        $pdf = Pdf::loadView('car_requests.print', compact('request'));

        $pdf->setOption([
            'defaultFont' => 'THSarabunNew',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'fontDir' => public_path('fonts/'),
            'fontCache' => storage_path('fonts/'),
            'chroot' => realpath(base_path()),
            'isPhpEnabled' => true,
            'isFontSubsettingEnabled' => true,
        ]);

        return $pdf->stream('document.pdf');
    }
}
