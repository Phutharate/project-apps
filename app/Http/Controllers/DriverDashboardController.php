<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VehicleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CarRequest;

class DriverDashboardController extends Controller
{
    public function driverDashboard()
    {
        $drivers = \App\Models\Driver::all();
        return view('car_requests.calendar', compact('drivers'));
    }


    public function assignedJobs(Request $request)
    {
        $driverName = Auth::user()->name;

        $query = CarRequest::where('driver', $driverName)
            ->where('status', 'approved');

        if ($request->filled('month')) {
            try {
                $month = \Carbon\Carbon::createFromFormat('Y-m', $request->month);
                $query->whereMonth('start_time', $month->month)
                    ->whereYear('start_time', $month->year);
            } catch (\Exception $e) {
                // ignore error (fallback to show all)
            }
        }

        $requests = $query->orderBy('start_time', 'asc')->get();

        return view('driver.assigned_jobs', compact('requests'));
    }
}
