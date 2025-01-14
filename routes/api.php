<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CompanieController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api.token')->group(function () {
    Route::get('/projects/{id}', [ProjectController::class, 'show']);

    Route::get('/companies/projects/{id}', [CompanieController::class, 'getCompanyProjects']);
    Route::get('/companies', [CompanieController::class, 'getAll']);
});