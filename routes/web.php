<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    GalleryController,
    PhotoController,
    InfoController,
    AgendaController,
    UserController,
    Admin\DashboardController,
    CommentController,
    LikeController,
    AlbumController,
    PictureController
};

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/gallery', [GalleryController::class, 'userindex'])->name('gallery.index');
    Route::get('/gallery/{gallery}/photos', [GalleryController::class, 'usershow'])->name('gallery.show');
    Route::get('/agenda', [AgendaController::class, 'userindex'])->name('agenda.index');
    Route::get('/info', [InfoController::class, 'userindex'])->name('info.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/photos/{id}/like', [PhotoController::class, 'toggleLike'])->name('photos.like');
    Route::get('/my-likes', [LikeController::class, 'index'])->name('likes.index');
    Route::get('/pictures/create', [PictureController::class, 'create'])->name('pictures.create');
    Route::post('/pictures', [PictureController::class, 'store'])->name('pictures.store');
    Route::delete('/pictures/{picture}', [PictureController::class, 'destroy'])->name('pictures.destroy');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/photos/{id}/comment', [PhotoController::class, 'storeComment'])->name('photos.comment.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
});

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'loginStore'])->name('login.store');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'registerStore'])->name('register.store');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');


Route::middleware(['auth', 'admin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/galleries', [GalleryController::class, 'adminIndex'])->name('galleries.index');
    Route::get('/galleries/create', [GalleryController::class, 'create'])->name('galleries.create');
    Route::post('/galleries', [GalleryController::class, 'store'])->name('galleries.store');
    Route::get('/galleries/{gallery}', [GalleryController::class, 'show'])->name('galleries.show');
    Route::get('/galleries/{gallery}/edit', [GalleryController::class, 'edit'])->name('galleries.edit');
    Route::put('/galleries/{gallery}', [GalleryController::class, 'update'])->name('galleries.update');
    Route::delete('/galleries/{gallery}', [GalleryController::class, 'destroy'])->name('galleries.destroy');
    Route::resource('photos', PhotoController::class);
    Route::resource('users', UserController::class);
    Route::resource('infos', InfoController::class); 
    Route::resource('agendas', AgendaController::class);
    Route::resource('albums', AlbumController::class);
    Route::resource('pictures', PictureController::class);
    Route::post('/dashboard/update-colors', [DashboardController::class, 'updateColors'])
        ->name('dashboard.update.colors');
    Route::post('/dashboard/update-logo', [DashboardController::class, 'updateLogo'])
        ->name('dashboard.update.logo');
    Route::post('/settings/colors', [App\Http\Controllers\DashboardController::class, 'updateColors'])->name('update.colors');
    Route::post('/settings/logo', [App\Http\Controllers\DashboardController::class, 'updateLogo'])->name('update.logo');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/colors', [App\Http\Controllers\Admin\SettingsController::class, 'updateColors'])->name('settings.update.colors');
    Route::post('/settings/logo', [App\Http\Controllers\Admin\SettingsController::class, 'updateLogo'])->name('settings.update.logo');
});


Route::get('/photos/{id}', [PhotoController::class, 'show'])->name('photos.show');
Route::post('/photos/{id}/comments', [PhotoController::class, 'storeComment'])->name('photos.comment.store');


Route::get('photos/{photo}/edit', [PhotoController::class, 'edit'])->name('dashboard.photos.edit');
Route::put('photos/{photo}', [PhotoController::class, 'update'])->name('dashboard.photos.update');
Route::delete('photos/{photo}', [PhotoController::class, 'destroy'])->name('dashboard.photos.destroy');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

Route::get('/albums', [AlbumController::class, 'userIndex'])->name('albums.index');
Route::get('/albums/{album}', [AlbumController::class, 'userShow'])->name('albums.show');

Route::get('/pictures/{id}', [PictureController::class, 'show'])->name('pictures.show');
Route::get('/pictures/{id}/download', [PictureController::class, 'download'])->name('pictures.download');

Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
Route::post('/dashboard/pictures/bulk-delete', [PictureController::class, 'bulkDelete'])->name('dashboard.pictures.bulk-delete');
