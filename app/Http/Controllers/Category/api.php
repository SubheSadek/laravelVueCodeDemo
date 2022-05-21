<?php

// ROUTE FILES ARE NOT REQUIRED TO IMPORT ANYWHRE.. ITS ADDED AUTOMATICALLY...

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Category\CategoryController;
// use Bugsnag\BugsnagLaravel\Facades\Bugsnag;



Route::group(['prefix'=>'category','middleware'=>'auth'],function (){

    Route::post('/editAdminUser',  [CategoryController::class, 'editAdminUser']);
    Route::post('/editAdminPassword',  [CategoryController::class, 'editAdminPassword']);
    Route::get('/stath',  [CategoryController::class, 'getstath']);


    //=============================== Categoris-Start ==================================
    Route::post('/addCategory',  [CategoryController::class, 'addCategory']);
    Route::post('/editCategory',  [CategoryController::class, 'editCategory']);
    Route::post('/deleteCategory',  [CategoryController::class, 'deleteCategory']);
    Route::get('/getAllCategories',  [CategoryController::class, 'getAllCategories']);
    //=============================== Categoris-End ==================================


    //=============================== Subcategoris-Start ==================================
    Route::post('/addSubcategory',  [CategoryController::class, 'addSubcategory']);
    Route::post('/editSubcategory',  [CategoryController::class, 'editSubcategory']);
    Route::post('/deletesubcategory',  [CategoryController::class, 'deletesubcategory']);
    Route::get('/getAllSubcategories',  [CategoryController::class, 'getAllSubcategories']);
    Route::get('/getCategories',  [CategoryController::class, 'getCategories']);
    //=============================== Subcategoris-End ==================================


    //=============================== Sub-Subcategories-Start ==================================
    Route::post('/addSubsubcategory',  [CategoryController::class, 'addSubsubcategory']);
    Route::post('/editSubsubcategory',  [CategoryController::class, 'editSubsubcategory']);
    Route::post('/deleteSubsubcategory',  [CategoryController::class, 'deleteSubsubcategory']);
    Route::get('/getAllSubsubcategories',  [CategoryController::class, 'getAllSubsubcategories']);
    Route::get('/getSubcategories',  [CategoryController::class, 'getSubcategories']);
    Route::get('/getSubsubcategories',  [CategoryController::class, 'getSubsubcategories']);
    //=============================== Sub-Subcategories-End ==================================


    //=============================== Information-Start ==================================
    Route::post('/addInformation',  [CategoryController::class, 'addInformation']);
    Route::post('/editInformation',  [CategoryController::class, 'editInformation']);
    Route::post('/deleteInformation',  [CategoryController::class, 'deleteInformation']);
    Route::get('/getAllInfo',  [CategoryController::class, 'getAllInfo']);
    Route::get('/searchInfo',  [CategoryController::class, 'searchInfo']);
    Route::get('/getSingleEditData',  [CategoryController::class, 'getSingleEditData']);
    Route::get('/getSingleEditData_two',  [CategoryController::class, 'getSingleEditData_two']);
    Route::get('/challengCategory',  [CategoryController::class, 'challengCategory']);
    //=============================== Information-End ==================================


    //=============================== Admin-Start ==================================
    Route::post('/createAdmin',  [CategoryController::class, 'createAdmin']);
    Route::post('/editAdmin',  [CategoryController::class, 'editAdmin']);
    Route::post('/deleteAdmin',  [CategoryController::class, 'deleteAdmin']);
    Route::get('/getAllAdmins',  [CategoryController::class, 'getAllAdmins']);
    //=============================== Admin-End ==================================


    //=============================== Categoris-Start ==================================
    Route::post('/addType',  [CategoryController::class, 'addType']);
    Route::post('/editType',  [CategoryController::class, 'editType']);
    Route::post('/deleteType',  [CategoryController::class, 'deleteType']);
    Route::get('/getAllTypes',  [CategoryController::class, 'getAllTypes']);
    Route::get('/getTypes',  [CategoryController::class, 'getTypes']);
    //=============================== Categoris-End ==================================


    //=============================== import-export-start ==================================
    Route::post('/importInfo',  [CategoryController::class, 'importInfo']);
    Route::post('/deleteAllInfo',  [CategoryController::class, 'deleteAllInfo']);
    Route::get('/testExel',  [CategoryController::class, 'testExel']);
    //=============================== import-export-End ==================================



});
