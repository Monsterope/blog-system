<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get("/", function(){
//     return config("database");
// });
Route::post("/login", [AuthController::class, "Login"]);
Route::post("/register", [AuthController::class, "Register"]);
Route::resource("blogs", BlogController::class)->only(['index']);

Route::group(["middleware" => ["auth:sanctum"]], function() {
    
    Route::post("logout", [AuthController::class, "Logout"]);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource("blogs", BlogController::class)->only(['show']);

    Route::group(["middleware" => ["isAdmin"]], function(){
        Route::resource("blogs", BlogController::class)->only(['store', 'update', 'destroy']);
        Route::post('/upload', [BlogController::class, "Upload"]);
    });
    
});

