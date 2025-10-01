<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CaseDiaryController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\RedirectIfNotApproved;
use App\Http\Controllers\CourtController;
use App\Http\Middleware\ChamberAccess;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page with 'approved' middleware
Route::get('/', [HomeController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth', RedirectIfNotApproved::class]);


// Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Pending approval page
Route::get('/approval-pending', fn() => view('pending'))->name('approval.pending');

// Approved User Access
Route::middleware(['auth', RedirectIfNotApproved::class])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.page');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/pending-lawyers', [AdminController::class, 'pendingLawyers'])->name('pending.lawyers');
        Route::post('/approve/{user}', [AdminController::class, 'approveLawyer'])->name('approve.user');
        Route::post('/deny/{user}', [AdminController::class, 'denyLawyer'])->name('deny.user');
    });

    // Case Diary
    
Route::prefix('cases')->name('cases.')->group(function () {
    Route::get('/', [CaseDiaryController::class, 'index'])->name('index');
    Route::get('/create', [CaseDiaryController::class, 'create'])->name('create');
    Route::post('/', [CaseDiaryController::class, 'store'])->name('store');

    Route::middleware(ChamberAccess::class)->group(function () {
        Route::get('/{caseDiary}', [CaseDiaryController::class, 'show'])->name('show');
        Route::get('/{caseDiary}/date-update', [CaseDiaryController::class, 'dateUpdate'])->name('date-update');
        Route::post('/{caseDiary}/date-update', [CaseDiaryController::class, 'updateDate'])->name('date-update.post');

Route::get('/date/{date}/edit', [CaseDiaryController::class, 'editDate'])->name('date-edit');

        Route::get('/{caseDiary}/edit', [CaseDiaryController::class, 'edit'])->name('edit');
        Route::put('/{caseDiary}', [CaseDiaryController::class, 'update'])->name('update');
        Route::delete('/{caseDiary}', [CaseDiaryController::class, 'destroy'])->name('destroy');
    });

    Route::get('/search', [CaseDiaryController::class, 'search'])->name('search');
    Route::get('/pdf-export', [CaseDiaryController::class, 'exportPdf'])->name('export.pdf');
});

    // courts
    Route::prefix('courts')->name('courts.')->group(function () {
        Route::get('/', [CourtController::class, 'index'])->name('index');
        Route::get('/create', [CourtController::class, 'create'])->name('create');
        Route::post('/', [CourtController::class, 'store'])->name('store');
        Route::get('/{court}/edit', [CourtController::class, 'edit'])->name('edit');
        Route::put('/{court}', [CourtController::class, 'update'])->name('update');
        Route::delete('/{court}', [CourtController::class, 'destroy'])->name('destroy');

        
    });

    // Staff Registration
    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('index'); // Staff list with edit, delete, approve
        Route::get('/create', [StaffController::class, 'create'])->name('create');
        Route::post('/store', [StaffController::class, 'store'])->name('store');
        Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('edit');
        Route::put('/{staff}', [StaffController::class, 'update'])->name('update');
        Route::delete('/{staff}', [StaffController::class, 'destroy'])->name('destroy');
        Route::post('/{staff}/inactive', [StaffController::class, 'inactive'])->name('inactive');
        Route::post('/{staff}/active', [StaffController::class, 'active'])->name('active');
    });

    // SMS & Dynamic DOCX
    Route::post('/send-sms', [SmsController::class, 'sendSms'])->name('send.sms');
    Route::post('/generate-docx', [CaseDiaryController::class, 'generateDocx'])->name('generate.docx');
    Route::post('/{case}/comment', [CaseDiaryController::class, 'addComment'])->name('comment.add');

    // Bkash Payment
    Route::get('/bkash/payment', [PaymentController::class, 'initiate'])->name('bkash.initiate');
    Route::post('/bkash/create-payment', [PaymentController::class, 'createPayment'])->name('bkash.create');
    Route::get('/bkash/callback', [PaymentController::class, 'callback'])->name('bkash.callback');
});
