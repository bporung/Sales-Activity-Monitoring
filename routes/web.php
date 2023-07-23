<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/register', function () {
    return redirect()->to('/login');
});
Route::get('/', function () {
    return redirect()->to('/login');
});


Route::get('/generate', function (){
    $targetFolder = '../appssource/storage/app/public';
    $linkFolder ='../public_html/storage';
    symlink($targetFolder,$linkFolder);
    echo 'Symlink completed';
});

Route::get('/clear-cache', function () {
'Illuminate\Support\Facades\Cache'::flush();
return "Cache Cleared";
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', App\Http\Livewire\Dashboard\Index::class)->name('dashboard');

Route::middleware(['auth:sanctum', 'verified', 'permission:read all user|read self user'])->get('/user', App\Http\Livewire\Master\User\Index::class)->name('userIndex');
Route::middleware(['auth:sanctum', 'verified', 'permission:create all user'])->get('/user/create', App\Http\Livewire\Master\User\Create::class)->name('userCreate');
Route::middleware(['auth:sanctum', 'verified', 'permission:read all user|read self user'])->get('/user/{id}', App\Http\Livewire\Master\User\Show::class)->name('userShow');
Route::middleware(['auth:sanctum', 'verified', 'permission:edit all user|edit self user'])->get('/user/{id}/edit', App\Http\Livewire\Master\User\Edit::class)->name('userEdit');
Route::middleware(['auth:sanctum', 'verified', 'permission:edit sales target'])->get('/user/{id}/editsales', App\Http\Livewire\Master\User\Editsales::class)->name('userEditSales');
Route::middleware(['auth:sanctum', 'verified', 'permission:edit all user'])->get('/user/{id}/editpassword', App\Http\Livewire\Master\User\Editpassword::class)->name('userEditPassword');
Route::middleware(['auth:sanctum', 'verified', 'permission:edit all user'])->get('/user/{id}/editsubordinate', App\Http\Livewire\Master\User\Editsubordinate::class)->name('userEditSubordinate');

Route::middleware(['auth:sanctum', 'verified', 'permission:read all customer|read self customer'])->get('/customer', App\Http\Livewire\Master\Customer\Index::class)->name('customerIndex');
Route::middleware(['auth:sanctum', 'verified', 'permission:create all customer'])->get('/customer/create', App\Http\Livewire\Master\Customer\Create::class)->name('customerCreate');
Route::middleware(['auth:sanctum', 'verified', 'permission:read all customer|read self customer'])->get('/customer/{id}', App\Http\Livewire\Master\Customer\Show::class)->name('customerShow');
Route::middleware(['auth:sanctum', 'verified', 'permission:edit all customer|edit self customer'])->get('/customer/{id}/edit', App\Http\Livewire\Master\Customer\Edit::class)->name('customerEdit');


Route::middleware(['auth:sanctum', 'verified', 'permission:create all interactiongroup|create self interactiongroup'])->get('/customer/{customer_id}/interactiongroup/create', App\Http\Livewire\Interactiongroup\Create::class)->name('interactionGroupCreate');
Route::middleware(['auth:sanctum', 'verified', 'permission:edit all interactiongroup|edit self interactiongroup'])->get('/customer/{customer_id}/interactiongroup/{id}/edit', App\Http\Livewire\Interactiongroup\Edit::class)->name('interactionGroupEdit');
Route::middleware(['auth:sanctum', 'verified', 'permission:read all interactiongroup|read self interactiongroup'])->get('/customer/{customer_id}/interactiongroup/{id}', App\Http\Livewire\Interactiongroup\Show::class)->name('interactionGroupShow');

Route::middleware(['auth:sanctum', 'verified', 'permission:read all interaction|read self interaction'])->get('/interaction', App\Http\Livewire\Interaction\Index::class)->name('interactionIndex');
Route::middleware(['auth:sanctum', 'verified', 'permission:read all interaction|read self interaction'])->get('/interaction/not_finalized', App\Http\Livewire\Interaction\IndexNotFinalized::class)->name('interactionIndexNotFinalized');
Route::middleware(['auth:sanctum', 'verified', 'permission:create all interaction|create self interaction'])->get('/customer/{customer_id}/interaction/create', App\Http\Livewire\Interaction\Create::class)->name('interactionCreate');
Route::middleware(['auth:sanctum', 'verified', 'permission:read all interaction|read self interaction'])->get('/customer/{customer_id}/interaction/{id}', App\Http\Livewire\Interaction\Show::class)->name('interactionShow');
Route::middleware(['auth:sanctum', 'verified', 'permission:edit all interaction|edit self interaction'])->get('/customer/{customer_id}/interaction/{id}/edit', App\Http\Livewire\Interaction\Edit::class)->name('interactionEdit');


Route::middleware(['auth:sanctum', 'verified', 'permission:read all item'])->get('/item', App\Http\Livewire\Master\Item\Index::class)->name('itemIndex');
Route::middleware(['auth:sanctum', 'verified', 'permission:create all item'])->get('/item/create', App\Http\Livewire\Master\Item\Create::class)->name('itemCreate');
Route::middleware(['auth:sanctum', 'verified', 'permission:read all item'])->get('/item/{id}', App\Http\Livewire\Master\Item\Show::class)->name('itemShow');
Route::middleware(['auth:sanctum', 'verified', 'permission:edit all item'])->get('/item/{id}/edit', App\Http\Livewire\Master\Item\Edit::class)->name('itemEdit');


Route::middleware(['auth:sanctum', 'verified', 'permission:read all interaction|read self interaction'])->get('/map/interaction', App\Http\Livewire\Map\Interaction\Index::class)->name('mapInteractionIndex');





Route::middleware(['auth:sanctum', 'verified', 'permission:read all report|create all report'])->get('/report/user/performances', App\Http\Livewire\Report\User\Performance\Index::class)->name('reportUsePerformanceIndex');
Route::middleware(['auth:sanctum', 'verified', 'permission:read all report|create all report'])->get('/report/user/performances/{id}', App\Http\Livewire\Report\User\Performance\Show::class)->name('reportUsePerformanceShow');


Route::middleware(['auth:sanctum', 'verified', 'permission:read all user|read self user'])->get('/report/user', App\Http\Livewire\Report\User\Index::class)->name('reportUserIndex');
Route::middleware(['auth:sanctum', 'verified', 'permission:read all user|read self user'])->get('/report/user/{id}', App\Http\Livewire\Report\User\Show::class)->name('reportUserShow');

Route::middleware(['auth:sanctum', 'verified'])->get('/notification', App\Http\Livewire\Notification\Index::class)->name('notificationIndex');


Route::middleware(['auth:sanctum', 'verified'])->get('/profile', App\Http\Livewire\Profile\Show::class)->name('profileShow');
Route::middleware(['auth:sanctum', 'verified'])->get('/profile/edit', App\Http\Livewire\Profile\Edit::class)->name('profileEdit');
Route::middleware(['auth:sanctum', 'verified'])->get('/profile/editpassword', App\Http\Livewire\Profile\Changepassword::class)->name('profileChangepassword');