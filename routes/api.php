<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Companies\CompaniesController;
use App\Http\Controllers\Internship\internshipController;
use App\Http\Controllers\Laporan\AdminLaporanController;
use App\Http\Controllers\laporan\LaporanController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Supervisors\SupervisorController;
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

        route::get('reportsa', [AdminLaporanController::class, 'index']);
        route::put('/reportsa/{id}', [AdminLaporanController::class, "update"]);
        route::delete('/reportsa/{id}', [AdminLaporanController::class, "destroy"]);

        route::get('supervisors', [SupervisorController::class, 'index']);
        route::get('supervisors/{id}', [SupervisorController::class, 'show']);
        route::post('supervisors', [SupervisorController::class, 'store']);
        route::delete('supervisors', [SupervisorController::class, 'destroy']);

        route::get('students', [StudentController::class, 'index']);
        route::post('students', [StudentController::class, 'store']);



        //Auth
        route::get('auth/me', [AuthController::class, 'Authme']);
    });
});
