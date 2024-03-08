<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\providerController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;


use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\MenuController as FrontendMenuController;
use App\Http\Controllers\Frontend\ReservationController as FrontendReservationController;
use App\Http\Controllers\Frontend\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [WelcomeController::class, 'index']);
Route::get('/categories', [FrontendCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [FrontendCategoryController::class, 'show'])->name('categories.show');
Route::get('/menus', [FrontendMenuController::class, 'index'])->name('menus.index');

Route::get('/cart', [FrontendMenuController::class, 'show'])->name('menus.show');
Route::get('/delete/{id}', [FrontendMenuController::class, 'destroy'])->name('menus.destroy');
Route::get('/increase/{id}/{count}', [FrontendMenuController::class, 'increase'])->name('menus.increase');
Route::get('/decrease/{id}/{count}', [FrontendMenuController::class, 'decrease'])->name('menus.decrease');

Route::get('/menus/store/{id}', [FrontendMenuController::class, 'store'])->name('menus.store');
Route::get('/reservation/step-one', [FrontendReservationController::class, 'stepOne'])->name('reservations.step.one');
Route::post('/reservation/step-one', [FrontendReservationController::class, 'storeStepOne'])->name('reservations.store.step.one');
Route::get('/reservation/step-two', [FrontendReservationController::class, 'stepTwo'])->name('reservations.step.two');
Route::post('/reservation/step-two', [FrontendReservationController::class, 'storeStepTwo'])->name('reservations.store.step.two');
Route::get('/thankyou', [WelcomeController::class, 'thankyou'])->name('thankyou');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth' , 'admin'])->name('admin.')->prefix('admin')->group(function(){
    Route::get('/' , [AdminController::class , 'index'])->name('index')  ;
    Route::resource('categories' , CategoryController::class) ;
    Route::resource('menus' , MenuController::class) ;
    Route::post('active/{id}' , [MenuController::class , 'active'])->name('menus.active') ;
    Route::get('/users', [UserController::class, 'items'])->name('userItems');
    Route::resource('tables' , TableController::class) ;
    Route::resource('reservation' , ReservationController::class) ;
}) ;

Route::get('/auth/{provider}/redirect', [providerController::class, 'redirect']);

Route::get('/auth/{provider}/callback', [providerController::class , 'callback' ]);


Route::get('/reservations', [UserController::class, 'showReservations'])->name('user.reservations');

Route::delete('/reservations/{id}', [ReservationController::class, 'cancel'])->name('reservation.cancel');




route::get('payIndex' , [StripeController::class , 'index'])->name('payment') ;
route::get('checkout' , [StripeController::class , 'checkout'])->name('checkout') ;
route::post('session' , [StripeController::class , 'session'])->name('session') ;
Route::get('/success', [StripeController::class , 'success'])->name('success');



require __DIR__.'/auth.php';
