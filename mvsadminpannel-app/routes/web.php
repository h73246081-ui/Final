<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Cms\Home\TestimonialController;
use App\Http\Controllers\Admin\Cms\Home\StatController;
use App\Http\Controllers\Admin\Cms\About\MissionController;
use App\Http\Controllers\Admin\Cms\About\AboutStatController;
use App\Http\Controllers\Admin\Cms\About\AboutTeamController;
use App\Http\Controllers\Admin\Cms\About\AboutJourneyController;
use App\Http\Controllers\Admin\Cms\About\AboutValueController;
use App\Http\Controllers\Admin\Role\RoleController;
use App\Http\Controllers\Admin\WebsiteSettingController;
use App\Http\Controllers\Admin\Cms\Contact\ContactController;
use App\Http\Controllers\Admin\Subscriber\SubscribeController;
use App\Http\Controllers\Admin\Cms\Blog\BlogController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\Product\CategoryController;
use App\Http\Controllers\Admin\Product\SubCategoryController;
use App\Http\Controllers\Admin\Vendor\VendorProfileController;
use App\Http\Controllers\Admin\Cms\Home\BrandController;
use App\Http\Controllers\Admin\Vendor\Product\ProductController;
use App\Http\Controllers\Admin\FlashDealController;
use App\Http\Controllers\Admin\TermCondition\TermConditionController;
use App\Http\Controllers\Section1Controller;
use App\Http\Controllers\Section2Controller;
use App\Http\Controllers\Section3Controller;
use App\Http\Controllers\Admin\Cms\Home\HeroSectionController;
use App\Http\Controllers\Admin\Vendor\Store\StoreController;
use App\Http\Controllers\Admin\PrivateSeller\PrivateSellerController;
use App\Http\Controllers\Admin\Reports\ReportController;
use App\Http\Controllers\Admin\Package\PackageController;
use App\Http\Controllers\Api\VendorProductController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();


Route::prefix('admin')->middleware(['auth','role:admin'])->group(function() {

   Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
//    Route::view('/profile', 'admin.profile')->name('admin.profile');
    Route::get('edit-profile',[DashboardController::class,'editProfile'])->name('admin.profile');
    Route::put('update-profile',[DashboardController::class,'updateProfile'])->name('update.profile');
    // term & services
    route::get('terms_condition',[TermConditionController::class,'indexTerm'])->name('indexTerm');
    route::post('store-term-conditions',[TermConditionController::class,'store'])->name('storeTerm');
    route::put('update-term-condition/{id}',[TermConditionController::class,'update'])->name('updateTerm');
    route::delete('delete-term-condition/{id}',[TermConditionController::class,'delete'])->name('deleteTerm');
    Route::get('/terms/{id}/edit', [TermConditionController::class, 'edit'])->name('editTerm');
    // privacy polices
    route::get('privacy-policices',[TermConditionController::class,'indexPolicy'])->name('indexPolicy');
    route::post('store-privacy-policices',[TermConditionController::class,'storePolicy'])->name('storePolicy');
    Route::get('/policy/{id}/edit', [TermConditionController::class, 'editPolicy'])->name('editTerm');
    route::put('update-privacy-policices/{id}',[TermConditionController::class,'updatePolicy'])->name('updatePolicy');
    route::delete('delete-privacy-policy/{id}',[TermConditionController::class,'deletePolicy'])->name('deletePolicy');
    // comission
    Route::get('comission',[DashboardController::class,'editComission'])->name('editComission');
    Route::put('comission',[DashboardController::class,'updateCommission'])->name('updateCommission');
    // product limit
    Route::get('product-limit',[DashboardController::class,'editLimit'])->name('editLimit');
    Route::put('update-product-limit',[DashboardController::class,'updateLimit'])->name('updateLimit');



    // all selers
    route::get('private-selers',[PrivateSellerController::class,'allPrivateSeller'])->name('allPrivateSellers');
    //all sub
    route::get('all-subcribers',[SubscribeController::class,'allSub'])->name('allSub');
    route::delete('delete-subcriber/{id}',[SubscribeController::class,'delete'])->name('deleteSub');
    // orders
    route::get('all-orders',[ReportController::class,'allOrder'])->name('allOrder');
    route::get('detail-order/{id}',[ReportController::class,'detailOrder'])->name('detailOrder');
    // packages
    Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
    Route::post('/packages/store', [PackageController::class, 'store'])->name('packages.store');
    Route::get('/packages/edit/{id}', function ($id) {
        return \App\Models\Package::findOrFail($id);
    });
    Route::put('/packages/update/{id}', [PackageController::class, 'update'])->name('packages.update');
    Route::delete('/packages/delete/{id}', [PackageController::class, 'destroy'])->name('packages.delete');
    Route::get('/seller-package', [PackageController::class, 'vendorPackage'])->name('vendorPackage');



   Route::prefix('products')->group(function() {
     Route::get('/show', [ProductController::class, 'index'])->name('product.index');
     Route::get('/{id}', [ProductController::class, 'show'])->name('product.show');
     Route::post('product/toggle-status', [ProductController::class, 'toggleStatus'])->name('product.toggleStatus');
   });


   Route::get('/all-stores', [StoreController::class, 'index'])->name('store.index');
   Route::get('detail-store/{id}', [StoreController::class, 'show'])->name('show');

   Route::prefix('flash-deals')->middleware(['auth'])->group(function() {
      Route::get('/show', [FlashDealController::class, 'index'])->name('flash.index');
      Route::get('/create', [FlashDealController::class, 'create'])->name('flash.create');
      Route::post('/store', [FlashDealController::class, 'store'])->name('flash.store');
      Route::delete('/delete/{id}', [FlashDealController::class, 'destroy'])->name('flash.destroy');
      Route::get('/edit/{id}', [FlashDealController::class, 'edit'])->name('flash.edit');
      Route::delete('/delete/{id}', [FlashDealController::class, 'destroy'])->name('flash.destroy');
      Route::put('/update/{id}', [FlashDealController::class, 'update'])->name('flash.update');
    });





   Route::prefix('categories')->group(function() {
      Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
      Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
      Route::get('/show', [CategoryController::class, 'show'])->name('category.index');
      Route::get('/edit{id}', [CategoryController::class, 'edit'])->name('category.edit');
      Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('category.update');
      Route::delete('/delete{id}', [CategoryController::class, 'destroy'])->name('category.delete');
   });

   Route::prefix('subategories')->group(function() {
      Route::get('/show', [SubCategoryController::class, 'index'])->name('subcategory.index');
      Route::get('/create', [SubCategoryController::class, 'create'])->name('subcategory.create');
      Route::post('/store', [SubCategoryController::class, 'store'])->name('subcategory.store');
      Route::get('/edit/{id}', [SubCategoryController::class, 'edit'])->name('subcategory.edit');
      Route::delete('/destroy/{id}', [SubCategoryController::class, 'destroy'])->name('subcategory.destroy');
      Route::put('/update/{id}', [SubCategoryController::class, 'update'])->name('subcategory.update');
   });

  Route::get('/website-setting', [WebsiteSettingController::class, 'WebsiteSetting'])->name('website.setting');
  Route::put('/website-settings-update', [WebsiteSettingController::class, 'update'])->name('website-settings.update');


   Route::prefix('testimonials')->group(function() {
     Route::get('/show', [TestimonialController::class,'index'])->name('cms.testimonial.index');
     Route::get('/create', [TestimonialController::class, 'create'])->name('cms.testimonials.create');
     Route::post('/store', [TestimonialController::class, 'store'])->name('cms.testimonials.store');
     Route::get('/edit/{id}', [TestimonialController::class, 'edit'])->name('edit.testimonial');
     Route::put('update/{id}', [TestimonialController::class, 'update'])->name('cms.testimonials.update');
     Route::delete('delete/{id}', [TestimonialController::class, 'destroy'])->name('delete.testimonial');
   });


   Route::get('/edit-hero-section', [HeroSectionController::class, 'editHero'])->name('editHero');
   Route::put('/hero-section/update', [HeroSectionController::class, 'update'])->name('admin.cms.home.hero_section.update');



   Route::prefix('categoriessection')->name('cms.')->group(function () {

    // Section 1
    Route::get('/section1/show', [Section1Controller::class, 'index'])->name('category1.index');
    Route::post('/section1/store', [Section1Controller::class, 'store'])->name('section1.store');

    // Section 2
    Route::get('/section2/show', [Section2Controller::class, 'index'])->name('category2.index2');
    Route::post('/section2/store', [Section2Controller::class, 'store'])->name('section2.store');

    // Section 3
    Route::get('/section3/show', [Section3Controller::class, 'index'])->name('category3.index3');
    Route::post('/section3/store', [Section3Controller::class, 'store'])->name('section3.store');

});




   Route::prefix('stats')->group(function() {
     Route::get('/edit', [StatController::class, 'edit'])->name('cms.stats.edit');
     Route::put('/update', [StatController::class, 'updateAll'])->name('cms.stat.update');
   });



   Route::prefix('brands')->group(function() {
     Route::get('/index', [BrandController::class, 'index'])->name('cms.brand.index');
     Route::get('/create', [BrandController::class, 'create'])->name('brands.create');
       Route::post('/store', [BrandController::class, 'store'])->name('brands.store');
           // Edit + Update
    Route::get('/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/{brand}/update', [BrandController::class, 'update'])->name('brands.update');

    // Delete
    Route::delete('/{brand}/destroy', [BrandController::class, 'destroy'])->name('brands.destroy');
   });



   Route::prefix('about')->group(function() {
      Route::get('our-mission', [MissionController::class, 'mission'])->name('cms.about.mission');
      Route::put('our-mission/update', [MissionController::class, 'update'])->name('about.mission.update');
      Route::get('edit-stat', [AboutStatController::class, 'AboutStat'])->name('cms.about.stat');
      Route::put('update-stat', [AboutStatController::class, 'updateAll'])->name('about.stat.update');
      Route::get('/team-create', [AboutTeamController::class, 'create'])->name('about.team.create');
      Route::post('/team-store', [AboutTeamController::class, 'store'])->name('about.team.store');
      Route::get('/team-show', [AboutTeamController::class, 'index'])->name('cms.about.team');
      Route::delete('/delete/{id}', [AboutTeamController::class, 'destroy'])->name('delete.team');
      Route::get('/edit/{id}', [AboutTeamController::class, 'edit'])->name('team.edit');
      Route::put('/update{id}', [AboutTeamController::class, 'update'])->name('team.update');
      Route::get('journey-show', [AboutJourneyController::class, 'journey'])->name('cms.about.journey');
      Route::get('journey-store', [AboutJourneyController::class, 'create'])->name('cms.journey.store');
      Route::post('journey-save', [AboutJourneyController::class, 'store'])->name('cms.journey.save');
      Route::get('journey-edit/{id}', [AboutJourneyController::class, 'edit'])->name('journey.edit');
      Route::put('journey-update/{id}', [AboutJourneyController::class, 'update'])->name('journey.update');
      Route::delete('journey-delete/{id}', [AboutJourneyController::class, 'delete'])->name('journey.delete');

      Route::get('/value-show', [AboutValueController::class, 'index'])->name('cms.about.value');
      Route::get('/value-store', [AboutValueController::class, 'create'])->name('cms.value.store');
      Route::post('/value-save', [AboutValueController::class, 'store'])->name('cms.value.save');
      Route::get('/value-edit/{id}', [AboutValueController::class, 'edit'])->name('cms.value.edit');
      Route::put('/value-update/{id}', [AboutValueController::class, 'update'])->name('cms.value.update');
      Route::delete('/value-delete/{id}', [AboutValueController::class, 'delete'])->name('cms.value.delete');

   });


   Route::prefix('contact')->group(function() {
     Route::get('message', [ContactController::class, 'contact'])->name('cms.contact.messages');
     Route::delete('delete-message/{id}', [ContactController::class, 'destroy'])->name('cms.contact.delete');
     Route::post('reply/{id}',[ContactController::class,'reply'])->name('contact.reply');
   });
   Route::put('update-banner', [ContactController::class, 'updateBanner'])->name('cms.update.banner');
   Route::get('edit-banner', [ContactController::class, 'editBanner'])->name('editBanner');


   Route::prefix('blogs')->group(function() {
      Route::get('/index', [BlogController::class ,'index'])->name('cms.blog.index');
      Route::get('/create', [BlogController::class ,'create'])->name('cms.blog.create');
      Route::post('/store', [BlogController::class, 'store'])->name('cms.blog.store');
      Route::delete('/delete/{id}', [BlogController::class, 'destroy'])->name('cms.blog.delete');
      Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('cms.blog.edit');
      Route::put('/update/{id}', [BlogController::class, 'update'])->name('cms.blog.update');
   });



   Route::prefix('roles')->group(function() {
     Route::get('/create', [RoleController::class, 'create'])->name('role.create');
     Route::get('/show', [RoleController::class, 'index'])->name('role.index');
     Route::post('/store', [RoleController::class, 'store'])->name('role.store');
     Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
    Route::get('/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('update-role/{id}', [RoleController::class, 'update'])->name('roles.update.role');
   });
   // permissions
   Route::get('all-permission', [RoleController::class, 'allPermission'])->name('allPermission');
   Route::post('store-permission', [RoleController::class, 'storePermission'])->name('storePermission');
   Route::put('update-permissions/{id}', [RoleController::class, 'updatePermission'])->name('permission.update');
   Route::delete('delete-permission/{id}', [RoleController::class, 'destroyPermission'])->name('destroyPermission');

   Route::get('edit-permission/{id}', [RoleController::class, 'editPermissions'])->name('editPermissions');
   Route::put('update-permission/{id}', [RoleController::class, 'assignPermissions'])->name('assignPermissions');




   Route::prefix('users')->group(function() {
       Route::get('/show', [UserController::class, 'index'])->name('user.index');
       Route::post('/store-user', [UserController::class, 'storeUser'])->name('user.store');

    //    Route::get('/roles', [UserController::class, ''])->name('user.index');

        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
   });


      Route::prefix('vendors')->group(function() {
      Route::get('/show', [VendorProfileController::class, 'vendor'])->name('vendor.index');
      Route::get('/buisness', [VendorProfileController::class, 'Buisnessvendor'])->name('vendor.busi');
      Route::put('/restrict/{id}', [VendorProfileController::class, 'redtrictVendor'])->name('vendor.restrict');
      Route::put('/approved/{id}', [VendorProfileController::class, 'activateVendor'])->name('vendor.approved');
      Route::delete('/delete-vendor/{id}', [VendorProfileController::class, 'deleteVendor'])->name('vendor.delete');
      Route::post('vendor/toggle-status', [VendorProfileController::class, 'toggleStatus'])->name('vendor.toggleStatus');

   });

});


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('product-store', [VendorProductController::class, 'store'])->name('storeProduct');
Route::get('add', [VendorProductController::class, 'testBlade']);
