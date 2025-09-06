<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\GenreMovieController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(\App\Http\Middleware\loginCustomer::class)->prefix('/customer')->group(function() {
    Route::get('/bookings/create/', [\App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
    Route::get('/bookings/history', [\App\Http\Controllers\BookingController::class, 'history'])->name('bookings.history');
    Route::get('/customers/account', [\App\Http\Controllers\CustomerController::class, 'account'])->name('customers.account');
    Route::get('/customers/{id}/edit}', [\App\Http\Controllers\CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{id}', [\App\Http\Controllers\CustomerController::class, 'update'])->name('customers.update');
    Route::post('/logout', [\App\Http\Controllers\CustomerController::class, 'logout'])->name('customers.logout');
});

Route::get('/vnpay-return', [\App\Http\Controllers\VNPayController::class, 'vnpayReturn'])->name('vnpay.return');
Route::post('/vnpay-create', [\App\Http\Controllers\VNPayController::class, 'createPayment'])->name('vnpay.create');

Route::prefix('/customer')->group(function() {
    Route::get('/login', [\App\Http\Controllers\CustomerController::class, 'login'])->name('customers.login');
    Route::post('/login_process', [\App\Http\Controllers\CustomerController::class, 'loginProcess'])->name('customers.loginProcess');
    Route::get('/index', [\App\Http\Controllers\CustomerController::class, 'index'])->name('customers.index');
    Route::get('/movies', [\App\Http\Controllers\MovieController::class, 'index'])->name('movies.index');
    Route::get('/movies/{id}', [\App\Http\Controllers\MovieController::class, 'details'])->name('movies.details');
    Route::get('/about', [\App\Http\Controllers\CustomerController::class, 'about'])->name('customers.about');
});

Route::get('/admin/create', [\App\Http\Controllers\AdminController::class, 'create'])->name('admin.create');
Route::post('/admin/create', [\App\Http\Controllers\AdminController::class, 'store'])->name('admin.store');

Route::get('/customer/create', [\App\Http\Controllers\AdminController::class, 'create'])->name('admin.create');
Route::post('/customer/create', [\App\Http\Controllers\CustomerController::class, 'store'])->name('customers.store');

Route::middleware(\App\Http\Middleware\loginAdmin::class)->prefix('/admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/index', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::get('/movies', [\App\Http\Controllers\AdminController::class, 'movies'])->name('admin.movies');
    Route::get('/movies/create', [\App\Http\Controllers\MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies/create', [\App\Http\Controllers\MovieController::class, 'store'])->name('movies.store');
    Route::delete('/movies/{id}', [\App\Http\Controllers\MovieController::class, 'destroy'])->name('movies.destroy');
    Route::get('/movies/{id}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/movies/{id}', [MovieController::class, 'update'])->name('movies.update');
    Route::get('/genres', [\App\Http\Controllers\GenreMovieController::class, 'index'])->name('genres.index');
    Route::get('/genres/create', [\App\Http\Controllers\GenreMovieController::class, 'create'])->name('genres.create');
    Route::post('/genres/create', [\App\Http\Controllers\GenreMovieController::class, 'store'])->name('genres.store');
    Route::resource('genre-movies', GenreMovieController::class);
    Route::delete('/genres/{id}', [GenreMovieController::class, 'destroy'])->name('genres.destroy');
    Route::get('/genres/{id}/edit', [GenreController::class, 'edit'])->name('genres.edit');
    Route::put('/genres/{id}', [GenreController::class, 'update'])->name('genres.update');
    Route::get('/snacks', [\App\Http\Controllers\SnackController::class, 'index'])->name('snacks.index');
    Route::get('/snacks/create', [\App\Http\Controllers\SnackController::class, 'create'])->name('snacks.create');
    Route::post('/snacks/create', [\App\Http\Controllers\SnackController::class, 'store'])->name('snacks.store');
    Route::get('/snacks/{id}/edit', [\App\Http\Controllers\SnackController::class, 'edit'])->name('snacks.edit');
    Route::put('/snacks/{id}', [\App\Http\Controllers\SnackController::class, 'update'])->name('snacks.update');
    Route::patch('/snacks/{id}/update-status', [\App\Http\Controllers\SnackController::class, 'update_status'])->name('snacks.update_status');
    Route::delete('/snacks/{id}', [\App\Http\Controllers\SnackController::class, 'destroy'])->name('snacks.destroy');
    Route::delete('/bookings/{id}', [\App\Http\Controllers\BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'index'])->name('admin.bookings');
    Route::get('/rooms', [\App\Http\Controllers\RoomController::class, 'index'])->name('admin.rooms');
    Route::get('/rooms/create', [\App\Http\Controllers\RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms/create', [\App\Http\Controllers\RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{id}/edit', [\App\Http\Controllers\RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{id}', [\App\Http\Controllers\RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{id}', [\App\Http\Controllers\RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::get('/showtimes', [\App\Http\Controllers\ShowtimeController::class, 'index'])->name('admin.showtimes');
    Route::get('/showtimes/create', [\App\Http\Controllers\ShowtimeController::class, 'create'])->name('showtimes.create');
    Route::post('/showtimes/check-conflict', [App\Http\Controllers\ShowtimeController::class, 'checkConflict'])->name('showtimes.checkConflict');
    Route::post('/showtimes/create', [\App\Http\Controllers\ShowtimeController::class, 'store'])->name('showtimes.store');
    Route::get('/showtimes/{id}/edit', [\App\Http\Controllers\ShowtimeController::class, 'edit'])->name('showtimes.edit');
    Route::put('/showtimes/{id}', [\App\Http\Controllers\ShowtimeController::class, 'update'])->name('showtimes.update');
    Route::delete('/showtimes/{id}', [\App\Http\Controllers\ShowtimeController::class, 'destroy'])->name('showtimes.destroy');
    Route::get('/locations', [\App\Http\Controllers\LocationController::class, 'index'])->name('admin.locations');
    Route::get('/locations/create', [\App\Http\Controllers\LocationController::class, 'create'])->name('locations.create');
    Route::post('/locations/create', [\App\Http\Controllers\LocationController::class, 'store'])->name('locations.store');
    Route::get('/locations/{id}/edit', [\App\Http\Controllers\LocationController::class, 'edit'])->name('locations.edit');
    Route::put('/locations/{id}', [\App\Http\Controllers\LocationController::class, 'update'])->name('locations.update');
    Route::delete('/locations/{id}', [\App\Http\Controllers\LocationController::class, 'destroy'])->name('locations.destroy');
    Route::get('/cinemas', [\App\Http\Controllers\CinemaController::class, 'index'])->name('admin.cinemas');
    Route::get('/cinemas/create', [\App\Http\Controllers\CinemaController::class, 'create'])->name('cinemas.create');
    Route::post('/cinemas/create', [\App\Http\Controllers\CinemaController::class, 'store'])->name('cinemas.store');
    Route::get('/cinemas/{id}/edit', [\App\Http\Controllers\CinemaController::class, 'edit'])->name('cinemas.edit');
    Route::put('/cinemas/{id}', [\App\Http\Controllers\CinemaController::class, 'update'])->name('cinemas.update');
    Route::delete('/cinemas/{id}', [\App\Http\Controllers\CinemaController::class, 'destroy'])->name('cinemas.destroy');
    Route::get('/rooms/{id}/seats', [\App\Http\Controllers\RoomController::class, 'viewSeats'])->name('rooms.seats');
    Route::post('/seats/bulk-disable', [\App\Http\Controllers\SeatController::class, 'bulkDisable'])->name('seats.bulkDisable');
    Route::get('/customers', [\App\Http\Controllers\CustomerController::class, 'show'])->name('admin.customers');
    Route::delete('/customers/{id}', [\App\Http\Controllers\CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::post('/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
});

Route::prefix('/admin')->group(function() {
    Route::get('/login', [\App\Http\Controllers\AdminController::class, 'login'])->name('admin.login');
    Route::post('/login_process', [\App\Http\Controllers\AdminController::class, 'loginProcess'])->name('admin.loginProcess');
});




