<?php

// ROUTE FILES ARE NOT REQUIRED TO IMPORT ANYWHRE.. ITS ADDED AUTOMATICALLY...

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Exel\ExelController;


Route::group(['prefix'=>'exel','middleware'=>'auth'],function (){
    Route::post('/testExel',  [ExelController::class, 'testExel']);
    Route::post('/testlaravelExel',  [ExelController::class, 'testlaravelExel']);
    Route::post('/testSimpleExel',  [ExelController::class, 'testSimpleExel']);
    Route::get('/testSimpleExel',  [ExelController::class, 'testSimpleExel']);

    Route::get('/db_backup',  [ExelController::class, 'db_backup']);
    Route::get('/show_backup',  [ExelController::class, 'show_backup']);
    Route::get('/download_backup',  [ExelController::class, 'download_backup']);
    Route::post('/deleteBackup',  [ExelController::class, 'deleteBackup']);
    
});

