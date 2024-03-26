<?php

use App\Http\Controllers\CheckInController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\InOutController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\StaffController;

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



Route::group(['middleware' => 'logOut'], function(){
    Route::get('/', [LoginController::class, 'showLogin'])->name('index');
    Route::post('/login', [LoginController::class, 'login'])->middleware('redirectIfAuthenticated')->name('login');
    Route::group(['middleware' => 'checkPassword'],function(){
        Route::get('/change-password', [LoginController::class, 'showViewchangePassword'])->name('password');
        Route::post('/password/change', [LoginController::class, 'changePassword'])->name('change.password');
    });
  
    Route::group(['middleware' => 'checkLogin'], function(){
       
        Route::group(['middleware' => 'role:admin'], function(){
            //dashboard
            Route::get('/dashboard', function () {
                return view('pages.dashboard.home');
            })->name('home');
            Route::post('/dashboard/search', [DashboardController::class, 'search'])->name('search');
            Route::get('/dashboard/index',[DashboardController::class, 'searchIndex'])->name('searchIndex');

            //Staff
            Route::resource('staff',StaffController::class);
           
            //inout
            Route::get('/inout', [InOutController::class,'index'])->name('inout.index');
        });

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        
        
        //member
        Route::resource('/member', MemberController::class);
        Route::get('/getQRCode', [MemberController::class, 'getQRCode'])->name('getQRCode');
        Route::get('/export-member', [MemberController::class, 'exportMember'])->name('member.export');
        Route::get('/member/{id}/print',[PDFController::class, 'PDF'])->name('print-member');

        //checkin
        Route::resource('/checkin', CheckInController::class);
        Route::get('/getMemberByCode', [CheckInController::class, 'getMemberByCode'])->name('checkin.getMemberByCode');
        Route::post('/create/guest',[CheckInController::class, 'storeGuest'])->name('checkin.guest');
       

    });
});

