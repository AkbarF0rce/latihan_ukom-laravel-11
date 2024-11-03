<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataMenu;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard_index');
});

Route::prefix('/menu')->group(function () {
    Route::get('/', [DataMenu::class, 'index'])->name('menu_index');
    Route::get('/listData', [DataMenu::class, 'listMenu'])->name('list_menu');
    Route::get('/tambahData', [DataMenu::class, 'tambahMenu'])->name('menu_tambah_data');
    Route::get('/editData', [DataMenu::class, 'editMenu'])->name('menu_edit_data');
    Route::post('/simpanTambahData', [DataMenu::class, 'simpanTambahMenu'])->name('menu_simpan_tambah_data');
    Route::put('/simpanEditData/{id}', [DataMenu::class, 'simpanEditMenu'])->name('menu_simpan_edit_data');
    Route::delete('/hapusData', [DataMenu::class, 'hapusMenu'])->name('menu_hapus_data');
    Route::get('/detailData', [DataMenu::class, 'detailMenu'])->name('menu_detail_data');
});
