<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiPassportAuthController;
use App\Http\Controllers\API\OrcamentoController;

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


/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 
*/



Route::group(['prefix' => 'v1'], function(){
    Route::post('register', [ApiPassportAuthController::class, 'registro']);
    Route::post('login', [ApiPassportAuthController::class, 'login']);
    
    //GRUPO PRA QUEM POSSUI AUTENTICACAO
    Route::middleware('auth:api')->group(function () {
        
        Route::get('logout', [ApiPassportAuthController::class, 'logout']);
        Route::get('get-user', [ApiPassportAuthController::class, 'userInfo']);
        Route::resource('orcamentos', OrcamentoController::class);
        Route::post('orcamentos', [OrcamentoController::class, 'atualizar']);
     
    });

    
    

});