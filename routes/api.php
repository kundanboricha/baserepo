<?php

use App\Http\Controllers\APIs\CheckInCheckOutController;
use App\Http\Controllers\APIs\LeaveController;
use App\Http\Controllers\APIs\ManageRoleAndPermissionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::controller(LeaveController::class)->prefix('/manage-leaves')->group(function () {
    Route::get('/response/{id}/{status}', 'leaveResponse')->name('api.leave-response');
});

