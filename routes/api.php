<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Companies\CompaniesController;
use App\Http\Controllers\Internship\internshipController;
use App\Http\Controllers\Laporan\AdminLaporanController;
use App\Http\Controllers\laporan\LaporanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


route::prefix("v1")->group(function () {
    route::post("register", [AuthController::class,"Register"]);
    route::post("login", [AuthController::class,"Login"]);
    route::post("logout", [AuthController::class,"Login"]);

    route::middleware("auth:sanctum")->group(function () {
        route::post("logout", [AuthController::class,"logout"]);


        route::get('intern', [internshipController::class,'index']);
        route::post('intern', [internshipController::class,'store']);

        route::get('companie', [CompaniesController::class,'index']);

        route::get("reports", [LaporanController::class, "index"]);



        route::get('repotsall', [AdminLaporanController::class, 'index'])   ;
    });
});
