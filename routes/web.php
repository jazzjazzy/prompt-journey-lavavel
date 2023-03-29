<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\PlansController;

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
    return redirect('dashboard');
});

Route::get('/terms-of-service', function () {
    return view('terms_of_service');
});

Route::get('/privacy-policy', function () {
    return view('privacy_policy');
});


Route::get('/auth/{provider}/redirect', [
    SocialiteController::class, 'redirect'
])->where('provider', 'facebook|google|github|twitter');

Route::get('/auth/{provider}/callback', [
    SocialiteController::class, 'callback'
])->where('provider', 'facebook|google|github|twitter');;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/pricing', [PlansController::class, 'index'])->name('subscription.pricing');
Route::middleware(['auth'])->group(function () {
    Route::get('/pricing/{plan}', [PlansController::class, 'show'])->name('subscription.pricing.show');
    Route::get('/subscribe/{plan}', [SubscriberController::class, 'showSubscriptionForm'])->name('subscription.subscribe');
    Route::delete('/subscribe', [SubscriberController::class, 'cancelSubscription'])->name('subscription.subscribe.cancel');
    Route::patch('/subscribe', [SubscriberController::class, 'resumeSubscription'])->name('subscription.subscribe.resume');
    Route::post('/subscribe', [SubscriberController::class, 'processSubscription'])->name('subscribe.processSubscription');
});


require __DIR__ . '/auth.php';
