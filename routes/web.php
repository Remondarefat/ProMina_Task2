<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', function () {
    return view('admin.login');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
Route::redirect('/login', '/user/login')->name('login');

// User Routes
Route::prefix('user')->group(function () {
    Route::get('/login', [AuthController::class, 'userLoginForm'])->name('user.login');
    Route::post('/login', [AuthController::class, 'userLogin']);
    Route::get('/register', [AuthController::class, 'userRegisterForm'])->name('user.register');
    Route::post('/register', [AuthController::class, 'userRegister']);
});
Route::post('logout', [AuthController::class, 'destroy'])
            ->name('logout');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'adminLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'adminLogin']);
});

// Admin Dashboard & Create Admins
Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/store', [AdminController::class, 'store'])->name('admin.store'); 
    Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::post('/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::post('/delete/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::post('/logout', [AdminController::class, 'destroy'])
            ->name('admin.logout');
});


// Post Routes
Route::middleware('auth:admin')->prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::get('/create/{category_id}', [PostController::class, 'create'])->name('posts.create');
    Route::post('/', [PostController::class, 'store'])->name('posts.store');
    Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});
Route::get('/get-posts', [PostController::class, 'getPost']);


// Categories Routes 
Route::middleware('auth:admin')->prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
});
Route::get('/get-categories', [CategoryController::class, 'getCategories']);



/* Route Tables */
Route::group(['prefix' => 'table'], function () {
    Route::get('', [TableController::class, 'table'])->name('table');
    Route::get('datatable/basic', [TableController::class, 'datatable_basic'])->name('datatable-basic');
    Route::get('datatable/advance', [TableController::class, 'datatable_advance'])->name('datatable-advance');
});
/* Route Tables */

// Route::get('/get-posts', [ServerController::class, 'getData'])->name('posts.getData');



