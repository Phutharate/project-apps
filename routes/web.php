<?php

use App\Http\Controllers\CarRequestController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CarApprovalController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarUsageController;
use App\Http\Controllers\ChiefDashboardController;
use App\Http\Controllers\FuelUsageController;
use App\Http\Controllers\FuelController;
use Illuminate\Http\Request;
use App\Http\Controllers\DriverDashboardController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\PersonalCarRequestController;
use App\Http\Controllers\PersonalCarApprovalController;
use App\Http\Controllers\ChiefDriverController;
use App\Http\Controllers\AdminDashboardController;

Route::post('/car-requests/set-date', function (Request $request) {
    $request->validate(['date' => 'required|date']);
    session(['car_request_date' => $request->date]);
    return response()->json(['status' => 'success']);
})->middleware('auth');



Route::resource('fuel', FuelUsageController::class);
Route::get('/fuel', [FuelController::class, 'index'])->name('fuel.index');


Route::resource('fuel', FuelController::class);


//use App\Livewire\UserForm;

//Route::get('/dashboard', function () {
//    return view('dashboard');
//});
//Route::get('/user', function () {
//   return view('user');
//});
//Route::resource('users', UserController::class);
//Route::resource('user-profiles', UserProfileController::class)->only([
//   'index', 'create', 'store' , 
//]);
//Route::get('/users', UserForm::class)->name('users.create');

Route::get('/', function () {
    return view('auth.login');
});

//Route Admin เฉพาระหน้า admin
//Route::middleware(['auth', 'role.admin'])->prefix('admin')->group(function () {
//   Route::get('/', [AdminDashboardController::class, 'adminDashboard'])->name('admin.dashboard');
//});


//Route Chief เฉพราะหน้า Chief
Route::get('/dashboard', [CarRequestController::class, 'calendar'])->middleware('auth')->name('dashboard'); //ให้chiefไปหน้าdashboardก่อน
Route::middleware(['auth'])->prefix('chief')->group(function () {
    Route::middleware('role:chief,driver')->group(function () {
        Route::get('/drivers', [ChiefDriverController::class, 'index'])->name('chief.drivers.index');
    });



    Route::get('/dashboard', [ChiefDashboardController::class, 'chiefDashboard'])->name('chief.dashboard');

    // หน้ารายการคำขอรถ (รออนุมัติ)
    Route::get('/car-requests/pending', [CarApprovalController::class, 'pending'])->name('chief.car-requests.pending');
    //ดูรายการอนุมัติ
    Route::get('/car-requests/approved', [CarApprovalController::class, 'approved'])->name('chief.car-requests.approved');
    //ดูรายการไม่อนุมัติ
    Route::get('/car-requests/rejected', [CarApprovalController::class, 'rejected'])->name('chief.car-requests.rejected');

    // การอนุมัติ / ไม่อนุมัติ
    Route::post('/car-requests/{id}/approve', [CarApprovalController::class, 'Chiefapprove'])->name('chief.car-requests.approve');
    Route::post('/car-requests/{id}/reject', [CarApprovalController::class, 'Chiefreject'])->name('chief.car-requests.reject');

    //เพิ่มแก้ไขคนขับรถ
    Route::get('/drivers', [ChiefDriverController::class, 'index'])->name('chief.drivers.index');
    Route::get('/drivers/create', [ChiefDriverController::class, 'create'])->name('chief.drivers.create');
    Route::post('/drivers', [ChiefDriverController::class, 'store'])->name('chief.drivers.store');
    Route::get('/drivers/{driver}/edit', [ChiefDriverController::class, 'edit'])->name('chief.drivers.edit');
    Route::delete('/drivers/{driver}', [ChiefDriverController::class, 'destroy'])->name('chief.drivers.destroy');
    Route::put('/drivers/{driver}', [ChiefDriverController::class, 'update'])->name('chief.drivers.update');
});

//Route User admin chief หน้าฟอร์มปกติ
Route::middleware(['auth'])->group(function () {
    Route::get('/car-requests/create', [CarRequestController::class, 'create'])->name('car-requests.create');
    Route::post('/car-requests', [CarRequestController::class, 'store'])->name('car-requests.store');
    Route::get('/car-requests/list', [CarRequestController::class, 'index'])->name('car-requests.list');
    Route::get('/user-dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
});

//Route::middleware(['auth', 'role.chief'])->group(function () {
//    Route::post('/requests/{id}/approve', [VehicleRequestApprovalController::class, 'approve'])->name('requests.approve');
//});
Route::middleware(['auth', \App\Http\Middleware\RoleDriverMiddleware::class])->prefix('driver')->group(function () {
    Route::get('/dashboard', [DriverDashboardController::class, 'driverDashboard'])->name('driver.dashboard');
    Route::get('/assigned-jobs', [DriverDashboardController::class, 'assignedJobs'])->name('driver.assigned_jobs');

    // ✅ เพิ่ม route สำหรับกดรับทราบ/ไม่รับทราบ
    Route::post('/acknowledge/{id}', [CarRequestController::class, 'acknowledge'])->name('driver.acknowledge');
});

Route::middleware(['auth', \App\Http\Middleware\RoleDirectorMiddleware::class])->prefix('director')->group(function () {
    Route::get('/dashboard', [DirectorController::class, 'dashboard'])->name('director.dashboard');
    Route::get('/requests', [DirectorController::class, 'directorlist'])->name('director.director_list');
});

//Route::middleware(['auth', \App\Http\Middleware\RoleDriverMiddleware::class])->prefix('driver')->group(function () {
//   Route::get('/dashboard', [DriverDashboardController::class, 'driverDashboard'])->name('driver.dashboard');

// Route::get('/assigned-jobs', [DriverDashboardController::class, 'assignedJobs'])->name('driver.assigned_jobs');
//});


Route::get('/notifications/read/{id}', function ($id) {
    $notification = Auth::user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    return redirect($notification->data['url'] ?? '/');
})->name('notifications.read');

Route::post('/car-requests/set-date', function (Request $request) {
    $request->validate(['date' => 'required|date']);
    session(['car_request_date' => $request->date]);
    return response()->json(['status' => 'success']);
})->middleware('auth');

// web.php  //สำหรับ print pdf
Route::get('/car-request/{id}/print', [CarRequestController::class, 'printForm'])->name('car_request.print');
Route::get('/font-test', function () {
    return view('car_requests.print', ['request' => \App\Models\CarRequest::first()]);
});

//Route::get('/admin-dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
Route::get('/calendar', [CarRequestController::class, 'calendar'])->middleware('auth')->name('car-requests.calendar');
Route::get('/car-requests/calendar-events', [CarRequestController::class, 'calendarEvents'])->middleware('auth');
Route::resource('car-requests', CarRequestController::class);
Route::resource('user-profiles', UserProfileController::class);

Route::resource('personal-car-requests', PersonalCarRequestController::class); //Route ของรถส่วนตัว   
Route::get('/chief/acknowledgements', [CarApprovalController::class, 'acknowledgementHistory'])->name('chief.acknowledgement_history'); // Route สำหรับรับทราบกับไม่รับทราบ

//สำหรับchiefอนุมัติคำร้อง รถส่วนตัว
Route::middleware(['auth', 'role.chief'])->prefix('chief/personal-requests')->group(function () {
    Route::get('/pending', [PersonalCarApprovalController::class, 'pending'])->name('chief.personal-requests.pending');
    Route::get('/approved', [PersonalCarApprovalController::class, 'approved'])->name('chief.personal-requests.approved');
    Route::get('/rejected', [PersonalCarApprovalController::class, 'rejected'])->name('chief.personal-requests.rejected');

    Route::post('/{id}/approve', [PersonalCarApprovalController::class, 'approve'])->name('chief.personal-requests.approve');
    Route::post('/{id}/reject', [PersonalCarApprovalController::class, 'reject'])->name('chief.personal-requests.reject');
});


//Route::get('/dashboard', function () {
//    return view('car_requests.calendar');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/car-usage/create', [CarUsageController::class, 'create'])->name('car-usage.create');
Route::post('/car-usage', [CarUsageController::class, 'store'])->name('car-usage.store');


Route::resource('car-usage', CarUsageController::class);




Route::patch('/chief/drivers/{id}/status', [ChiefDriverController::class, 'updateStatus'])->name('chief.drivers.updateStatus');

Route::resource('fuel', FuelUsageController::class);
Route::get('/fuel', [FuelController::class, 'index'])->name('fuel.index');



require __DIR__ . '/auth.php';
