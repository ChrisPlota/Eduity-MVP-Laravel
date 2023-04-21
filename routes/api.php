<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsersController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/jwttoken/create', [ApiTokenController::class, 'create'])->name('jwttoken.create');
Route::post('/jwttoken/createapi', [ApiTokenController::class, 'tokenFetch'])->name('jwttoken.tokenFetch');
Route::post('/jwttoken/create', [ApiTokenController::class, 'authenticate'])->name('jwttoken.authenticate');

Route::middleware('jwt.verify')->group(static function () {
    Route::resource('users', UsersController::class)->only([
        'index', 'show', 'update', 'destroy'
    ]);
    Route::resource('organizations', OrganizationsController::class)->only([
        'index', 'store', 'show', 'update', 'destroy'
    ]);
    Route::get('/organizations/owner/{id}', [OrganizationsController::class, 'owner'])->name('organizations.owner');
});

Route::resource('users', UsersController::class)->only([
    'store'
]);
