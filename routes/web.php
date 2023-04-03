<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ProjectController;
use \App\Http\Controllers\ImagesController;

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

Route::get('/dashboard/{projectId}', function ($projectId = null) {
    return view('dashboard', ['projectId' => $projectId]);
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
});

//ajax based routes
Route::post('/projects/{project}/prompt-history', [ProjectController::class, 'updatePromptHistory']);
Route::post('/projects/{project}/images', [ProjectController::class, 'updateImages']);
Route::post('/projects/{project}/suffix', [ProjectController::class, 'updateSuffix']);

//modal based routes
Route::get('/suffix', function () {return view('modals.suffix');})->name('modals.suffix');
//Route::get('/images', function () {return view('modals.images');})->name('modals.images');
Route::get('/image/{project?}',  [ImagesController::class, 'view'])->name('modals.images');
Route::post('/images/{project}/save',  [ImagesController::class, 'save'])->name('images.save');

Route::get('/history', function () {return view('modals.history');})->name('modals.history');

require __DIR__ . '/auth.php';
