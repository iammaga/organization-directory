<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::get('/buildings', [BuildingController::class, 'index']);
Route::get('/buildings/{building}/organizations', [BuildingController::class, 'organizations']);
Route::get('/organizations/search', [OrganizationController::class, 'search']);
Route::get('/organizations/nearby', [OrganizationController::class, 'nearby']);
Route::get('/organizations/{organization}', [OrganizationController::class, 'show']);
Route::get('/activities/{activity}/organizations', [ActivityController::class, 'organizations']);
