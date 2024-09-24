<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\userController;

// working for dashboard Controller
Route::get('/', [DashboardController::class, 'view'])->name('dashboard');

// Working For Categories
Route::get('/categories', [CategoryController::class, 'view'])->name('categories');
Route::get('/add/categorypage', [CategoryController::class, 'addpage'])->name('addnewcatepage');
Route::post('/addcategory', [CategoryController::class, 'add'])->name('addcategory');
Route::get('/updatecategorystatus', [CategoryController::class, 'status'])->name('updatecategorystatus');
Route::get('/category/updatepage/{id}', [CategoryController::class, 'updatepage'])->name('categoryupdatepage');
Route::post('/updatecategory/{id}', [CategoryController::class, 'update'])->name('updatecategory');

// working for Countries
Route::get('/countries', [CountryController::class, 'view'])->name('countries');
Route::get('/add/country/page', [CountryController::class, 'addpage'])->name('addnewcountrypage');
Route::post('/addcountry', [CountryController::class, 'add'])->name('addcountry');
Route::get('/updatecountrystatus', [CountryController::class, 'status'])->name('updatecountrystatus');
Route::get('/country/updatepage/{id}', [CountryController::class, 'updatepage'])->name('countryupdatepage');
Route::post('/updatecountry/{id}', [CountryController::class, 'update'])->name('updatecountry');

// working for states
Route::get('/states',[StateController::class,'view'])->name('states');
Route::get('add/state/page',[StateController::class,'addpage'])->name('addnestatepage');
Route::post('/addstate',[StateController::class,'add'])->name('addstate');
Route::get('/updatestatestatus',[StateController::class,'status'])->name('updatestatestatus');
Route::get('/state/updatepage/{id}',[StateController::class,'updatepage'])->name('stateupdatepage');
Route::post('updatestate/{id}',[StateController::class,'update'])->name('updatestate');
Route::get('get/states/detaisl/{id}',[StateController::class,'details'])->name('getstates');

// working for cities
Route::get('getcities', [CityController::class, 'view'])->name('cities');
Route::get('/add/city/', [CityController::class, 'addpage'])->name('addnewcitypage');
Route::post('/addcity', [CityController::class, 'add'])->name('addcountry');
Route::get('/updatecitystatus', [CityController::class, 'status'])->name('updatecitystatus');
Route::get('/city/updatepage/{id}', [CityController::class, 'updatepage'])->name('cityupdatepage');
Route::post('/updatecity/{id}', [CityController::class, 'update'])->name('updatecity');
Route::get('getcities/details/{id}', [CityController::class, 'details'])->name('getcities'); // get cities details according to country

// working for onboarding ads 
Route::get('/get/onboardings',[OnboardingController::class,'view'])->name('onboarding');
Route::get('/add/onboarding',[OnboardingController::class,'addpage'])->name('addonboardingpage');
Route::get('/update/onboardingstatus',[OnboardingController::class,'status'])->name('updateonboardingstatus');





// working for Users
Route::get('/users', [userController::class, 'view'])->name('users');
Route::get('adduserpage',[userController::class,'addpage'])->name('adduserpage');
Route::get('/check/username', [userController::class, 'checkUsername'])->name('check.username');
Route::get('/check/email/user', [userController::class, 'checkEmail'])->name('check.email.user');
Route::get('/check/phone', [userController::class, 'checkPhone'])->name('check.phone.user');
Route::get('/check/password/match', [userController::class, 'checkPasswordMatch'])->name('check.password.match');
Route::post('adduser',[userController::class,'add'])->name('adduser');
Route::get('/updateuserstatus', [userController::class, 'status'])->name('updateuserstatus');
Route::get('/userdetails/{id}',[userController::class,'usersdetails'])->name('userdetails');
Route::get('/edit/userdetails/page/{id}',[userController::class,'editpage'])->name('userupdatepage');
Route::post('/updateuserdetails/{id}',[userController::class,'update'])->name('user.upate');
