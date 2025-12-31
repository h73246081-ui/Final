<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\Home\TestimonialController;
use App\Http\Controllers\Api\Admin\Home\StatController;
use App\Http\Controllers\Api\Admin\About\MissionController;
use App\Http\Controllers\Api\Admin\About\AboutStatController;
use App\Http\Controllers\Api\Admin\About\AboutTeamController;
use App\Http\Controllers\Api\Contact\ContactController;
use App\Http\Controllers\Api\Vendor\SignupController;
use App\Http\Controllers\Api\Customer\RegisterController;
use App\Http\Controllers\Api\Setting\SettingController;
use App\Http\Controllers\Api\Admin\Blog\BlogController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Category\SubCategoryController;
use App\Http\Controllers\Api\VendorProfileController;
use App\Http\Controllers\Api\VendorProductController;
use App\Http\Controllers\Api\Admin\Home\BrandController;
use App\Http\Controllers\Api\Category\CategoryProductController;
use App\Http\Controllers\Api\FlashDealController;
use App\Http\Controllers\Api\Section1Controller;
use App\Http\Controllers\Api\Section2Controller;
use App\Http\Controllers\Api\Section3Controller;
use App\Http\Controllers\Api\Admin\Home\HeroSectionController;
use App\Http\Controllers\Api\VendorStoreController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){


    Route::get('/vendor/profile', [VendorProfileController::class,'show']);
    Route::post('/vendor/profile-update', [VendorProfileController::class,'store']);


    //==============//
    // Vendors Products //

    Route::get('/vendor/products', [VendorProductController::class, 'index']);
    Route::get('/vendor/products/{id}', [VendorProductController::class, 'show']);
    Route::post('/vendor/product-store', [VendorProductController::class, 'store']);
    Route::post('/vendor/products/{id}', [VendorProductController::class, 'update']);
    Route::delete('/vendor/products/{id}', [VendorProductController::class, 'destroy']);


       //==============//
    // Vendors Store //

    Route::post('/vendor-store', [VendorStoreController::class, 'store']);
    Route::get('/vendors', [VendorStoreController::class, 'myStore']);


});



    // All vendors (public API)
Route::get('/vendor-stores', [VendorStoreController::class, 'allStores']);
Route::get('store/{id}', [VendorStoreController::class, 'storeDetail']);


Route::post('signup-vendor', [SignupController::class, 'vendorSignup']);
Route::post('signup-customer', [RegisterController::class, 'customerSignup']);
Route::post('/login', [RegisterController::class, 'login']);
Route::post('/logout', [RegisterController::class, 'logout']);



//...... Home Setion ...... //
Route::get('/testimonials', [TestimonialController::class, 'testimonial']);
Route::get('/stats', [StatController::class, 'stats']);
Route::get('/brands', [BrandController::class, 'brand']);
Route::get('/hero-section', [HeroSectionController::class, 'index']);

//...... About Setion ...... //
Route::get('/about-our-mission', [MissionController::class, 'mission']);
Route::get('/about-value', [MissionController::class, 'index']);//
Route::get('/about-stats', [AboutStatController::class, 'AboutStat']);
Route::get('/about-journy', [MissionController::class, 'journy']);//
Route::get('/about-team', [AboutTeamController::class, 'index']);

// ....... Contatct Section ......//
Route::post('/contact', [ContactController::class, 'contact']);
Route::get('/contact-info', [ContactController::class, 'ContactInfo']);
Route::get('/contact-social', [ContactController::class, 'ContactSocial']);

// ....... Contatct Section ......//
Route::get('/setting', [SettingController::class, 'website']);

// ....... Contatct Section ......//
Route::get('/blog', [BlogController::class, 'blog']);
Route::get('/blog/{id}', [BlogController::class, 'blogDetail']);

// .......... Category Section ......//
Route::get('/categories', [CategoryController::class, 'category']);
Route::get('/subcategories', [SubCategoryController::class, 'SubCategory']);
Route::get('/categories-with-sub', [CategoryController::class, 'categoriesWithSub']);

Route::get('/categories-with-products', [CategoryController::class, 'index']);
Route::get('/products', [CategoryController::class, 'allProducts']);
Route::get('/product/{id}', [CategoryController::class, 'productDetail']);

Route::get('/category/{id}/products', [CategoryController::class, 'productsByCategory']);
Route::get('/recent-products', [CategoryController::class, 'recentProducts']);


Route::get('/category-count', [CategoryController::class, 'categorycount']);  // new api




Route::get('flash-deals', [FlashDealController::class, 'index']);
Route::get('/flash/get-products/{category}', [FlashDealController::class, 'getProductsByCategory'])
    ->name('flash.products.by.category');

Route::get('/section1', [Section1Controller::class, 'index']);
Route::get('/section2', [Section2Controller::class, 'index']);
Route::get('/section3', [Section3Controller::class, 'index']);
