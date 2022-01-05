<?php

use App\Http\Controllers\Order as ControllersOrder;
use App\Http\Controllers\User as ControllersUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [ControllersUser::class, 'store']);

Route::post('login', [ControllersUser::class, 'login']);

Route::post('order', [ControllersOrder::class, 'store']);

Route::get('verify/{token}', function ($token) {
    $json = [];
    $status = 200;

    $user = User::where('remember_token', $token)->first();
    
    if ($user) {
        $user->email_verified_at = Carbon::now()->toDateTimeString();
        $user->save();
        $json = ['message' => 'Verified'];
    } else {
        $json = ['message' => 'Invalid user'];
        $status = 400;
    }

    return response()->json($json, $status);
});