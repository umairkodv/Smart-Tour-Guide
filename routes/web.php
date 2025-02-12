<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\TouristController;
use App\Http\Controllers\HotelVendorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomePagesController;
use App\Http\Controllers\TourPlannerController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\PasswordController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return redirect('/');
});
Route::get('/about', function () {
    return view('mainpages.about');
});
Route::get('/contact', function () {
    return view('mainpages.contact');
});
Route::get('/destination', function () {
    return view('mainpages.destination');
});
Route::get('/gallery', function () {
    return view('mainpages.gallery');
});

Route::get('create-trip',[TripController::class,'createTrip'])->name('create_trip');
Route::post('store-trip',[TripController::class,'storeTrip'])->name('store_trip');
Route::get('view/{id}',[TripController::class,'view'])->name('view_trip');
Route::get('edit/{id}',[TripController::class,'edit'])->name('edit_trip');
Route::get('delete/{id}',[TripController::class,'delete'])->name('delete_trip');
Route::post('update/{id}',[TripController::class,'update'])->name('update_trip');
Route::get('search',[HomePagesController::class,'search'])->name('search');
Route::get('hotels',[HomePagesController::class,'hotels'])->name('hotels');
Route::get('fetch-driver', [TripController::class, 'find_driver']);
//
Route::get('accept-trip/{id}', [DriverController::class, 'accept'])->name('except.request');
Route::get('reject-trip/{id}', [DriverController::class, 'reject'])->name('reject.request');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/change-password', [PasswordController::class, 'update'])->name('password.update');
});

// Admin Routes
Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
    // Trips Routes
    Route::get('/admin/view/all-plans/', [AdminController::class, 'all_plans'])->name('admin.trips.all');
    Route::get('admin/trip/view/{id}',[AdminController::class,'view_trip'])->name('admin.view_trip');
    Route::get('/admin/reports/', [AdminController::class, 'reports'])->name('admin.reports');

});

// Hotel Vendor Routes
Route::group(['middleware' => 'hotel_vendor'], function () {
    Route::get('/hotel/vendor/dashboard', [HotelVendorController::class, 'dashboard'])->name('vendor.dashboard');

});

// Tourist Routes
Route::group(['middleware' => 'tourist'], function () {
    Route::get('/tourist/vendor/dashboard', [TouristController::class, 'dashboard'])->name('tourist.dashboard');
    Route::get('/tourist/vendor/trips', [TripController::class, 'index'])->name('tourist.trips');
    Route::post('/post/comment', [TouristController::class, 'add_comment'])->name('add.comment');

});

// Driver Routes
Route::group(['middleware' => 'driver'], function () {
    Route::get('/driver/vendor/dashboard', [DriverController::class, 'dashboard'])->name('driver.dashboard');
    // Route::get('/tourist/vendor/trips', [TripController::class, 'index'])->name('tourist.trips');

});

Route::get('/tour-planner', [TourPlannerController::class, 'index'])->name('tour_planner.index');
Route::post('tour-planner/plan', [TourPlannerController::class, 'planTour'])->name('tour_planner.plan');

