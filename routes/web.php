<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NicheController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ServiceNameController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\userController;


// // login Route
Route::get('/', [SuperadminController::class, 'loginpage'])->name('loginpage')->middleware('logcheck');
Route::post('login/superadmin', [SuperadminController::class, 'login'])->name('login.post')->middleware('logcheck');



Route::middleware(['isAdminlogin'])->group(function () {

    Route::get('/logout', [SuperadminController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'view'])->name('dashboard');
    // Working For Categories
    Route::get('/categories', [CategoryController::class, 'view'])->name('categories');
    Route::get('/add/categorypage', [CategoryController::class, 'addpage'])->name('addnewcatepage');
    Route::post('/addcategory', [CategoryController::class, 'add'])->name('addcategory');
    Route::get('/updatecategorystatus', [CategoryController::class, 'status'])->name('updatecategorystatus');
    Route::get('/category/updatepage/{id}', [CategoryController::class, 'updatepage'])->name('categoryupdatepage');
    Route::post('/updatecategory/{id}', [CategoryController::class, 'update'])->name('updatecategory');


    // working for niche 
    Route::get('/niches', [NicheController::class, 'view'])->name('niches');
    Route::get('/niche/addpage', [NicheController::class, 'addpage'])->name('nicheaddpage');
    Route::get('/updatenichestatus', [NicheController::class, 'status'])->name('updatenichestatus');
    Route::post('/addniche', [NicheController::class, 'add'])->name('addniche');
    Route::get('niche/updatepage/{id}', [NicheController::class, 'updatepage'])->name('nicheupdatepage');
    Route::post('update/niche/{id}', [NicheController::class, 'update'])->name('updateniche');

    // working for ServiceNames
    Route::get('/servicesnames', [ServiceNameController::class, 'view'])->name('service.names');




    // working for Countries
    Route::get('/countries', [CountryController::class, 'view'])->name('countries');
    Route::get('/add/country/page', [CountryController::class, 'addpage'])->name('addnewcountrypage');
    Route::post('/addcountry', [CountryController::class, 'add'])->name('addcountry');
    Route::get('/updatecountrystatus', [CountryController::class, 'status'])->name('updatecountrystatus');
    Route::get('/country/updatepage/{id}', [CountryController::class, 'updatepage'])->name('countryupdatepage');
    Route::post('/updatecountry/{id}', [CountryController::class, 'update'])->name('updatecountry');

    // working for states
    Route::get('/states', [StateController::class, 'view'])->name('states');
    Route::get('add/state/page', [StateController::class, 'addpage'])->name('addnestatepage');
    Route::post('/addstate', [StateController::class, 'add'])->name('addstate');
    Route::get('/updatestatestatus', [StateController::class, 'status'])->name('updatestatestatus');
    Route::get('/state/updatepage/{id}', [StateController::class, 'updatepage'])->name('stateupdatepage');
    Route::post('updatestate/{id}', [StateController::class, 'update'])->name('updatestate');
    Route::get('get/states/detaisl/{id}', [StateController::class, 'details'])->name('getstates');


    // working for cities
    Route::get('getcities', [CityController::class, 'view'])->name('cities');
    Route::get('/add/city/', [CityController::class, 'addpage'])->name('addnewcitypage');
    Route::post('/addcity', [CityController::class, 'add'])->name('addcountry');
    Route::get('/updatecitystatus', [CityController::class, 'status'])->name('updatecitystatus');
    Route::get('/city/updatepage/{id}', [CityController::class, 'updatepage'])->name('cityupdatepage');
    Route::post('/updatecity/{id}', [CityController::class, 'update'])->name('updatecity');
    Route::get('getcities/details/{id}', [CityController::class, 'details'])->name('getcities'); // get cities details according to country

    // working for onboarding ads 
    Route::get('/get/onboardings', [OnboardingController::class, 'view'])->name('onboarding');
    Route::get('/add/onboarding/page', [OnboardingController::class, 'addpage'])->name('addonboardingpage');
    Route::post('/addonboarding', [OnboardingController::class, 'add'])->name('addonboarding');
    Route::get('/update/onboardingstatus', [OnboardingController::class, 'status'])->name('updateonboardingstatus');
    Route::post('/delete/onboardingadd', [OnboardingController::class, 'destroy'])->name('deleteonboarding');
    Route::get('/onboarding/updatepage/{id}', [OnboardingController::class, 'updatepage'])->name('onboardingupdatepage');
    Route::post('update/onboardingadd/{id}', [OnboardingController::class, 'update'])->name('updateonboarding');


    // working for Users
    Route::get('/users', [userController::class, 'view'])->name('users');
    Route::get('adduserpage', [userController::class, 'addpage'])->name('adduserpage');
    Route::get('/check/username', [userController::class, 'checkUsername'])->name('check.username');
    Route::get('/check/email/user', [userController::class, 'checkEmail'])->name('check.email.user');
    Route::get('/check/phone/user', [userController::class, 'checkPhone'])->name('check.phone.user');
    Route::post('adduser', [userController::class, 'add'])->name('adduser');
    Route::get('/updateuserstatus', [userController::class, 'status'])->name('updateuserstatus');
    Route::get('/userdetails/{id}', [userController::class, 'usersdetails'])->name('userdetails');
    Route::get('/edit/userdetails/page/{id}', [userController::class, 'editpage'])->name('userupdatepage');
    Route::post('/updateuserdetails/{id}', [userController::class, 'update'])->name('user.upate');
    Route::get('/updateaccount/status/{status}/{user}', [userController::class, 'accountstatus'])->name('updateaccountstatus');

    // merchant route

    Route::get('all/professionals', [ProfessionalController::class, 'view'])->name('Professional');
    Route::get('add/new/professional/page', [ProfessionalController::class, 'addpage'])->name('professionaladdpage');
    Route::get('/check/username/professional', [ProfessionalController::class, 'checkUsername'])->name('check.username.proffessional');
    Route::get('/check/email/professional', [ProfessionalController::class, 'checkEmail'])->name('check.email.user');
    Route::get('/check/phone/merchant', [ProfessionalController::class, 'checkPhone'])->name('check.phone.professional');
    Route::post('/create/new/professional', [ProfessionalController::class, 'add'])->name('createprofessional');
    Route::get('/professioanl/details/page/{id}', [ProfessionalController::class, 'professionaldetails'])->name('professionaldetails');
    Route::get('/updateaccount/professional/status/{status}/{user}', [ProfessionalController::class, 'accountstatus'])->name('update.pro.status');
    Route::get('update/professional/page/{id}', [ProfessionalController::class, 'updatepage'])->name('update.prof.page');
    Route::post('update/professional/{id}', [ProfessionalController::class, 'update'])->name('updateprofessionl');
});
