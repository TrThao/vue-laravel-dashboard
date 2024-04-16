<?php

use App\Http\Controllers\API\Authenticate;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\Auth\AuthBlogController;
use App\Http\Controllers\Auth\AuthCategoryController;
use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\RolePermissionController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(Authenticate::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['middleware' => ['role:admin|editor']], function () {
        //category
        Route::get('/category', [AuthCategoryController::class, 'index']);
        Route::post('create/category', [AuthCategoryController::class, 'store']);
        Route::get('/category/{id}', [AuthCategoryController::class, 'show']);
        Route::put('/category/{category}', [AuthCategoryController::class, 'update']);
        Route::delete('/category/{category}', [AuthCategoryController::class, 'delete']);



        Route::get('/blog', [AuthBlogController::class, 'index']);
        Route::post('create/blog', [AuthBlogController::class, 'store']);
        Route::get('/blog/{id}', [AuthBlogController::class, 'show']);
        Route::post('/blog/{id}', [AuthBlogController::class, 'update'])->middleware(['permission:blog-edit']);
        Route::delete('/blog/{blog}', [AuthBlogController::class, 'delete']);
    });

    Route::group(['middleware' => ['role:admin']], function () {
        //user
        Route::get('/user', [AuthUserController::class, 'index']);
        Route::post('create/user', [AuthUserController::class, 'store']);
        Route::get('/user/{id}', [AuthUserController::class, 'show']);
        Route::post('/user/{user}', [AuthUserController::class, 'update']);
        Route::delete('/user/{user}', [AuthUserController::class, 'delete']);

        //user update pass
        Route::post('changepassword/user/{user}', [ChangePasswordController::class, 'updatePassuser']);


        // Role
        Route::get('/roles', [RoleController::class, 'index']);
        Route::post('create/roles', [RoleController::class, 'store']);
        Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
        Route::post('/update/roles/{id}', [RoleController::class, 'update']);
        Route::get('/roles/{id}', [RoleController::class, 'show']);



        Route::get('/permissions', [PermissionController::class, 'index']);
        Route::post('/create/permissions', [PermissionController::class, 'store']);
        Route::get('/permissions/{id}', [PermissionController::class, 'show']);
        Route::post('/update/permissions/{id}', [PermissionController::class, 'update']);
        Route::delete('/permissions/{id}', [PermissionController::class, 'destroy']);




        Route::get('/roles/{role}/permissions', [RolePermissionController::class, 'getRolePermissions']);

        Route::post('/roles/{role}/permissions', [RolePermissionController::class, 'assignPermissions']);
    });
});