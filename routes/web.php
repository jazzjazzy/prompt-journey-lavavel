<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SuffixController;
use App\Http\Controllers\SuffixListController;
use App\Http\Controllers\DashBoardController;
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
})->name('tos');

Route::get('/privacy-policy', function () {
    return view('privacy_policy');
})->name('privacy');

Route::get('/history', function () {
    return view('modals.history');
})->name('modals.history');

Route::get('/auth/{provider}/redirect', [
    SocialiteController::class, 'redirect'
])->where('provider', 'facebook|google|github|twitter');

Route::get('/auth/{provider}/callback', [
    SocialiteController::class, 'callback'
])->where('provider', 'facebook|google|github|twitter');;

Route::get('/dashboard',  [DashBoardController::class, 'view'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/{projectId?}',  [DashBoardController::class, 'viewUser'])->middleware(['auth', 'verified'])->name('dashboard.project');

Route::get('/pricing', [PlansController::class, 'index'])->name('subscription.pricing');
Route::get('/page/pricing', [PlansController::class, 'modal'])->name('subscription.pricing.modal');

Route::middleware(['auth'])->group(function () {
    // profiles
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //pricing subscribers
    Route::get('/pricing/{plan}', [PlansController::class, 'show'])->name('subscription.pricing.show');
    //subscription
    Route::get('/subscribe/{plan}', [SubscriberController::class, 'showSubscriptionForm'])->name('subscription.subscribe');
    Route::delete('/subscribe', [SubscriberController::class, 'cancelSubscription'])->name('subscription.subscribe.cancel');
    Route::patch('/subscribe', [SubscriberController::class, 'resumeSubscription'])->name('subscription.subscribe.resume');
    Route::post('/subscribe', [SubscriberController::class, 'processSubscription'])->name('subscribe.processSubscription');
    // projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project_Id}/edit', [ProjectController::class, 'edit'])->name('project.edit');
    Route::get('/projects/add', [ProjectController::class, 'add'])->name('project.add');
    Route::post('/projects/save/{project_id?}', [ProjectController::class, 'save'])->name('project.save');
    Route::delete('/projects/{id}/delete', [ProjectController::class, 'delete'])->name('project.delete');

    Route::get('/suffix/{project?}', [SuffixController::class, 'view'])->name('modals.suffix');
    Route::get('/image/{project?}', [ImagesController::class, 'view'])->name('modals.images');
});

//ajax based routes
Route::middleware(['auth', 'subscription', 'verified'])->group(function () {
    Route::post('/projects/{project}/prompt-history', [ProjectController::class, 'updatePromptHistory']);
    Route::get('/projects/{project}/history', [ProjectController::class, 'getPromptHistory']);
    Route::get('/projects/{project}/clearHistory', [ProjectController::class, 'clearPromptHistory']);
    Route::post('/projects/{project}/images', [ProjectController::class, 'updateImages']);
    Route::post('/projects/{project}/suffix', [ProjectController::class, 'updateSuffix']);

    //modal based routes
    Route::get('/suffix/{project}/{suffix}', [SuffixController::class, 'edit'])->name('suffix.edit');
    Route::post('/suffix/{project}/save', [SuffixController::class, 'save'])->name('suffix.save');
    Route::get('/suffixes/list', [SuffixListController::class, 'view'])->name('suffixes.view');
    Route::get('/suffixes/list/{group?}', [SuffixListController::class, 'viewSuffixes'])->name('suffix.list');

    Route::get('/image/{project}/{images}', [ImagesController::class, 'edit'])->name('images.edit');
    Route::post('/images/{project}/save', [ImagesController::class, 'save'])->name('images.save');

    Route::get('/gallery', [GalleryController::class, 'view'])->name('gallery.view');
    Route::get('/gallery/{group?}', [GalleryController::class, 'viewImages'])->name('gallery.images');

    Route::get('/history', function () {
        return view('modals.history');
    })->name('modals.history');
});

require __DIR__ . '/auth.php';
