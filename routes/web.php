<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public Front-End Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/urunler', [ProductController::class, 'index'])->name('products.index');
Route::get('/urunler/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/hikayemiz', [HomeController::class, 'about'])->name('about');
Route::get('/iletisim', [HomeController::class, 'contact'])->name('contact');
Route::post('/iletisim', [HomeController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');

// Admin Guest Routes
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'loginSubmit'])->name('admin.login.submit');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Redirect standard guest redirect to admin login
Route::get('/login', function() {
    return redirect()->route('admin.login');
})->name('login');

// Admin Authenticated Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::post('/products/store', [AdminController::class, 'productStore'])->name('products.store');
    Route::post('/products/update/{id}', [AdminController::class, 'productUpdate'])->name('products.update');
    Route::post('/products/toggle-stock/{id}', [AdminController::class, 'productToggleStock'])->name('products.toggle-stock');
    Route::post('/products/delete/{id}', [AdminController::class, 'productDelete'])->name('products.delete');
    
    // Categories CRUD
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories/store', [AdminController::class, 'categoryStore'])->name('categories.store');
    Route::post('/categories/update/{id}', [AdminController::class, 'categoryUpdate'])->name('categories.update');
    Route::post('/categories/delete/{id}', [AdminController::class, 'categoryDelete'])->name('categories.delete');

    // Messages Inbox
    Route::get('/messages', [AdminController::class, 'messages'])->name('messages');
    Route::post('/messages/delete/{id}', [AdminController::class, 'messageDelete'])->name('messages.delete');
    Route::post('/messages/read/{id}', [AdminController::class, 'messageRead'])->name('messages.read');
    
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings/update', [AdminController::class, 'settingsUpdate'])->name('settings.update');
});
