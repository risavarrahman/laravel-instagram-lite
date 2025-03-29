<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



// Route::get('/dashboard2', function () {
//     return view('dashboard2');
// })->middleware(['auth', 'verified'])->name('dashboard2');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/post/upload', [PostController::class, 'upload'])->name('post.upload');
    Route::get('/post/archive', [PostController::class, 'archive'])->name('post.archive');
    Route::delete('/post/archive/{post}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::get('/post/archive/export/pdf', [PostController::class, 'exportPdf'])->name('archive.export.pdf');
    Route::get('/post/archive/export/xlsx', [PostController::class, 'exportXlsx'])->name('archive.export.xlsx');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');
});

require __DIR__ . '/auth.php';
