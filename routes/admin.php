<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\RecipeController;
use App\Http\Controllers\Admin\SiteSectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('site-sections', SiteSectionController::class)->only(['index', 'edit', 'update']);
Route::resource('banners', BannerController::class)->except(['show']);
Route::resource('categories', CategoryController::class)->except(['show']);
Route::delete('products/{product}/images/{product_image}', [ProductImageController::class, 'destroy'])->name('products.images.destroy');
Route::resource('products', ProductController::class)->except(['show']);
Route::resource('recipes', RecipeController::class)->except(['show']);
Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
Route::get('contact-messages/{contact_message}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
