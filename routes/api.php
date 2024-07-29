<?php

use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\CustomerController;
use App\Http\Controllers\API\v1\ExampleNoteController;
use App\Http\Controllers\Api\v1\TestController;
use App\Http\Controllers\API\v1\UserController;
//----------------------------------------------------//
use App\Http\Controllers\API\v1\OrderController;
use App\Http\Controllers\API\v1\PayOrderController;
use App\Http\Controllers\API\v1\MudjaiController;
use App\Http\Controllers\API\v1\EmailController;
//----------------------------------------------------//
use Illuminate\Support\Facades\Route;

Route::controller(TestController::class)
    ->prefix('test')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/error', 'testError');
        Route::get('/validation', 'validationError');
        Route::get('/querynotfound', 'queryNotFound');
        Route::get('/manualthrow', 'manualThrow');
        Route::get('/codeerror', 'codeError');
        Route::get('/randomname', 'ramdomNameByUserId');
        Route::post('/upload-file', 'uploadFile');
        Route::get('/try-static-token', 'tryStaticToken');
    });

Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware('auth:sanctum');
        Route::post('register', 'register');
    });

Route::controller(UserController::class)
    ->prefix('user')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/', 'get');
        Route::post('/profile', 'updateProfile');
    });

Route::controller(ExampleNoteController::class)
    ->prefix('example-note')
    ->group(function () {
        Route::get('/', 'getAll');
        Route::get('{id}', 'getById');
        Route::post('/', 'create');
    });

Route::controller(CustomerController::class)
    ->prefix('customers')
    ->group(function () {
        Route::post('/', 'register');
        Route::patch('/me', 'updateMe')->middleware('auth:sanctum');
        Route::get('/me', 'getMe')->middleware('auth:sanctum');
        Route::get('/me/address', 'getAddressMe')->middleware('auth:sanctum');
        Route::get('/brands/{brand}/customers/{customer}/tax-ids', 'getTaxAddress')->middleware('auth:sanctum');
        Route::post('/brands/{brand}/customers/{customer}/tax-ids', 'createTaxAddress')->middleware('auth:sanctum');
    });
Route::controller(OrderController::class)
    ->prefix('orders')
    ->group(function () {
        Route::post('/sendorder', 'sendOrder');//->middleware('auth:sanctum');
        Route::post('/send2order', 'send2Order');//->middleware('auth:sanctum');
        Route::post('/shoppingcrt', 'shoppingcrt');//->middleware('auth:sanctum');
        Route::get('/getorder/{ordno}', 'getorder');//->middleware('auth:sanctum');
        Route::get('/getorderbycustomer/{custid}', 'getbycustomer');//->middleware('auth:sanctum');
        Route::get('/getorderstatus/{ordno}', 'getorderstatus');//->middleware('auth:sanctum');
        Route::get('/getorderpayment/{ordno}', 'getordpay');//->middleware('auth:sanctum');
    });

Route::controller(PayOrderController::class)
    ->prefix('takeorder')
    ->group(function () {
        Route::get('/getpaymentlink/{ordno}', 'linkpayorder');//->middleware('auth:sanctum');
        Route::get('/getpaymentchannel', 'getpaychannel');//->middleware('auth:sanctum');
    });

Route::controller(MudjaiController::class)
    ->prefix('mudjai')
    ->group(function () {
        Route::get('/getmudjaimember/{query}', 'mudjaicrm');//->middleware('static_token_auth');
        Route::get('/mudjaimemberid/{memberid}', 'mudjaimemberid');//->middleware('static_token_auth');
        Route::get('/mudjaimemberphone/{phonenumber}', 'mudjaimemberphone');//->middleware('static_token_auth');
    });

Route::get('api-docs', function () {
    return redirect('/docs/index.html');
});