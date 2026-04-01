<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\TourGuideController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\BookingController as ClientBookingController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\GroupController;

use App\Http\Controllers\Guide\GuideController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Admin\DashboardController;
/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
| Các route không cần đăng nhập
|
*/

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('contact', [HomeController::class,'contact'])->name('contact');


/*
|--------------------------------------------------------------------------
| TOUR CLIENT
|--------------------------------------------------------------------------
*/

Route::prefix('tours')->name('client.tours.')->group(function () {

    //  TÌM KIẾM TOUR (FILTER FULL)
    Route::get('/search', [HomeController::class,'search'])
        ->name('search');

    //  CHI TIẾT TOUR
    Route::get('/{slug}', [HomeController::class,'show'])
        ->name('show');

});
/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.post');
});


Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class,'index'])
            ->name('dashboard');

        // CRUD Category
        Route::resource('categories', CategoryController::class);

        // CRUD Tour
        Route::resource('tours', TourController::class);

        // CRUD Itinerary
        Route::post('/tours/{tour}/itineraries', [\App\Http\Controllers\Admin\TourItineraryController::class,'store'])
            ->name('tours.itineraries.store');

        Route::delete('/itineraries/{id}', [\App\Http\Controllers\Admin\TourItineraryController::class,'destroy'])
            ->name('itineraries.destroy');

        // CRUD Tour Guide
        Route::resource('guides', TourGuideController::class);

        // CRUD User
        Route::resource('users', UserController::class);

        // CRUD Trip (Lịch khởi hành)
        Route::resource('trips', TripController::class);

         // BOOKING
        Route::resource('bookings', AdminBookingController::class);

        // đổi trạng thái booking
        Route::put('/bookings/{id}/status',[AdminBookingController::class,'updateStatus'])
            ->name('bookings.status');

        // Quan lý đoàn khởi hành
        Route::resource('groups', GroupController::class);

        // phân công guide
        Route::put('/groups/{id}/assign-guide',
            [GroupController::class,'assignGuide'])
            ->name('groups.assignGuide');

        // danh sách điểm danh
        Route::get('/attendances', [\App\Http\Controllers\Admin\AttendanceController::class,'index'])
            ->name('attendances.index');

        // chi tiết điểm danh
        Route::get('/attendances/{id}', [\App\Http\Controllers\Admin\AttendanceController::class,'show'])
            ->name('attendances.show');
});


/*
|--------------------------------------------------------------------------
| GUIDE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:guide'])
    ->prefix('guide')
    ->name('guide.')
    ->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [GuideController::class,'dashboard'])
            ->name('dashboard');


        Route::get('/groups', [GuideController::class,'groups'])
            ->name('groups');

        // CHI TIẾT TOUR ĐƯỢC PHÂN CÔNG
        Route::get('/groups/{id}', [GuideController::class,'groupDetail'])
            ->name('groups.detail');

        Route::get('/groups/{id}/customers', [GuideController::class,'customers'])
            ->name('customers');

        Route::get('/groups/{id}/attendance', [GuideController::class,'attendance'])
            ->name('attendance');

        Route::post('/groups/{id}/attendance', [GuideController::class,'saveAttendance'])
            ->name('attendance.save');

        //  LỊCH SỬ TOUR ĐÃ DẪN
        Route::get('/history', [GuideController::class,'history'])
            ->name('history');

        // chi tiết tour
        Route::get('/guide/groups/{id}', [GuideController::class, 'groupDetail'])
        ->name('guide.groups.detail');
});


/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('clients.home');
        })->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| BOOKING - USER (PHẢI ĐĂNG NHẬP)
|--------------------------------------------------------------------------
*/


Route::middleware(['auth','role:user'])
    ->prefix('booking')
    ->name('booking.')
    ->group(function () {

        // form đặt tour
        Route::get('/create/{trip}', [ClientBookingController::class,'create'])
            ->name('create');

        // lưu booking
        Route::post('/store', [ClientBookingController::class,'store'])
            ->name('store');

        // lịch sử booking
        Route::get('/history', [ClientBookingController::class,'myBookings'])
            ->name('history');

        // chi tiết booking
        Route::get('/detail/{id}', [ClientBookingController::class,'show'])
            ->name('show');

});


/*
|--------------------------------------------------------------------------
| PAYMENT - USER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:user'])
    ->prefix('payment')
    ->name('payment.')
    ->group(function () {

        // chuyển sang cổng thanh toán VNPAY
        Route::get('/vnpay/{booking}', [PaymentController::class,'vnpay_payment'])
            ->name('vnpay');

        //  thanh toán phần còn lại
        Route::get('/vnpay-final/{booking}', [PaymentController::class,'vnpayFinal'])
            ->name('vnpayFinal');

        // trang return từ VNPAY
        Route::get('/vnpay-return', [PaymentController::class,'vnpayReturn'])
            ->name('vnpayReturn');

         //  lịch sử thanh toán
        Route::get('/history', [PaymentController::class,'history'])
            ->name('history');

        //  CHI TIẾT THANH TOÁN
        Route::get('/{id}', [PaymentController::class,'show'])
            ->name('show');
});