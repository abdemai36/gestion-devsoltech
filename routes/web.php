<?php

use App\Http\Controllers\ArchiffeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EntreController;
use App\Http\Controllers\SorterController;
use App\Http\Controllers\UserEntreController;
use App\Http\Controllers\UserSortieController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

//auth route for both 
Route::group(['middleware' => ['auth']], function() { 
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
});

//for admin 
Route::group(['middleware' => ['auth', 'role:admin']], function() { 
    Route::get('/employee', [EmployeeController::class,'index'])->name('admin.employee');
    Route::get('/employee/create', [EmployeeController::class,'create'])->name('admin.create');
    Route::post('/employee/store', [EmployeeController::class,'store'])->name('admin.store');
    Route::post('/employee/delete/{id}', [EmployeeController::class,'deleteEmploye'])->name('admin.delete');
    Route::get('/edit/{id}', [EmployeeController::class,'edit'])->name('admin.edit');
    Route::put('/employee/update/{id}', [EmployeeController::class,'update'])->name('admin.update');

    //Entre
    Route::get('/entre', [EntreController::class,'index'])->name('admin.entre');
    Route::get('/entre/create', [EntreController::class,'create'])->name('admin.create.entre');
    Route::post('/entre/store', [EntreController::class,'store'])->name('admin.store.entre');
    Route::post('/entre/delete/{id}', [EntreController::class,'destroy'])->name('admin.delete.entre');
    Route::post('/entre/valider/{id}', [EntreController::class,'valide'])->name('admin.valide.entre');
    Route::get('/entreedit/{id}', [EntreController::class,'edit'])->name('admin.edit.entre');
    Route::put('/entre/update/{id}', [EntreController::class,'update'])->name('entre.update');
    Route::get('/entre/exportPDF', [EntreController::class,'exportPDF'])->name('entre.exportPDF');
    Route::get('/entre/exportarchive', [EntreController::class,'exportArchiffe'])->name('entre.exportArchive');
    Route::get('/archive/entre', [EntreController::class,'selectArchiffeEntre'])->name('admin.archive.entre');
    Route::get('/archive/exportPDF/entre', [EntreController::class,'exportArchivePDF'])->name('archive.exportPDF.entre'); 
    
    //Sortie
    Route::get('/sorte', [SorterController::class,'index'])->name('admin.sorte');
    Route::get('/sorte/create', [SorterController::class,'create'])->name('admin.create.sorte');
    Route::post('/sorte/store', [SorterController::class,'store'])->name('admin.store.sorte');
    Route::post('/sorte/delete/{id}', [SorterController::class,'destroy'])->name('admin.delete.sorte');
    Route::post('/sorte/valider/{id}', [SorterController::class,'valide'])->name('admin.valide.sorte');
    Route::get('/sorteedit/{id}', [SorterController::class,'edit'])->name('admin.edit.sorte');
    Route::put('/sorte/update/{id}', [SorterController::class,'update'])->name('sorte.update');
    Route::get('/sorte/exportPDF', [SorterController::class,'exportPDF'])->name('sorte.exportPDF');
    Route::get('/sorte/exportarchive', [SorterController::class,'exportArchiffe'])->name('sorte.exportArchive');
    Route::get('/archive/sorte', [SorterController::class,'selectArchiffeSorte'])->name('admin.archive.sorte');
    Route::get('/archive/exportPDF', [SorterController::class,'exportArchivePDF'])->name('archive.exportPDF.sorte'); 
    
});

//for user 
Route::group(['middleware' => ['auth','role:user']], function() { 
    //Entre
    Route::get('/user/entre', [UserEntreController::class,'index'])->name('user.entre');
    Route::get('/user/create/', [UserEntreController::class,'create'])->name('user.create.entre');
    Route::post('/user/store/', [UserEntreController::class,'store'])->name('user.store.entre');
    Route::get('/user/exportPDF', [UserEntreController::class,'exportPDF'])->name('user.entre.exportPDF');
    Route::post('/user/entre/delete/{id}', [EntreController::class,'destroy'])->name('user.delete.entre');
    Route::get('/entreEdit/{id}', [UserEntreController::class,'edit'])->name('user.edit.entre');
    Route::put('/user/entre/update/{id}', [EntreController::class,'update'])->name('user.entre.update');

     //Sortie
     Route::get('/user/sortie', [UserSortieController::class,'index'])->name('user.sortie');
     Route::get('/user/CreateSortie/', [UserSortieController::class,'create'])->name('user.create.sortie');
     Route::post('/user/Sortiestore/', [UserSortieController::class,'store'])->name('user.store.sortie');
     Route::get('/user/sortie/exportPDF', [UserSortieController::class,'exportPDF'])->name('user.sortie.exportPDF');
     Route::post('/user/sortie/delete/{id}', [SorterController::class,'destroy'])->name('user.delete.sortie');
     Route::get('/sortieEdit/{id}', [UserSortieController::class,'edit'])->name('user.edit.sortie');
     Route::put('/user/sortie/update/{id}', [SorterController::class,'update'])->name('user.sortie.update');
});

require __DIR__.'/auth.php';
