<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\AuthManagerController;
use App\Http\Controllers\backend\HomeController;
use App\Http\Controllers\backend\UserAccountController;
use App\Http\Controllers\backend\ForgetPasswordController;
use App\Http\Controllers\backend\OTPController;
use App\Http\Controllers\backend\RoomCategoryController;
use App\Http\Controllers\backend\OurRoomController;
use App\Http\Controllers\backend\SiteSettingController;
use App\Http\Controllers\backend\TeamMemberController;
use App\Http\Controllers\backend\DocumentController;
use App\Http\Controllers\backend\TestimonialController;
use App\Http\Controllers\backend\FaqCategoryController;
use App\Http\Controllers\backend\FaqController;
use App\Http\Controllers\backend\OurValueController;
use App\Http\Controllers\backend\WhyToChooseUsController;
use App\Http\Controllers\backend\AboutUsController;
use App\Http\Controllers\backend\MessageController;
use App\Http\Controllers\backend\PostController;
use App\Http\Controllers\backend\RoomController;
use App\Http\Controllers\backend\RoomAmenitiesController;
use App\Http\Controllers\backend\SeasonController;
use App\Http\Controllers\TestController;


Route::get('/login',[AuthManagerController::class,'login'])->name('login');
Route::post('/login',[AuthManagerController::class,'loginPost'])->name('login.post');
Route::get('/logout',[AuthManagerController::class,'logout']);
Route::get('/forgetpassword',[ForgetPasswordController::class,'index'])->name('forgetpassword');
Route::get('/otp',[OTPController::class,'index'])->name('otp');
Route::post('validotp',[OTPController::class,"isValidOtp"])->name('validotp');
Route::post('/checkuser',[ForgetPasswordController::class,'isRegisteredUser'])->name('checkuser');
Route::post('updatepassword',[ForgetPasswordController::class,'updatePassword'])->name('updatepassword');
Route::get('/resetpassword',[OTPController::class,'indexResetPassword'])->name('resetpassword');


Route::group(['middleware'=>'auth'],function(){

     Route::prefix('admin')->name('admin.')->group(function(){
        Route::get('/dashboard',[HomeController::class,'index'])->name('dashboard');

        // Create user account-start
        Route::group(['prefix'=>'account'],function(){
            Route::get('/',[UserAccountController::class,'index'])->name('account');
            Route::post('/form',[UserAccountController::class,'form'])->name('account.form');
            Route::post('/save',[UserAccountController::class,'save'])->name('account.save');
            Route::post('/list',[UserAccountController::class,'list'])->name('account.list');
            Route::post('/delete',[UserAccountController::class,'delete'])->name('account.delete');
            Route::post('regenerate',[UserAccountController::class,'regenerate'])->name('account.regenerate');
        });
        // Create user account -end

        Route::group(['prefix'=>'rooms'],function(){
            Route::get('/',[RoomCategoryController::class,'index'])->name('rooms');
            Route::post('/save',[RoomCategoryController::class,'save'])->name('rooms.save');
            Route::post('/list',[RoomCategoryController::class,'list'])->name('rooms.list');
            Route::post('/delete',[RoomCategoryController::class,'delete'])->name('rooms.delete');
            Route::post('/restore',[RoomCategoryController::class,'restore'])->name('rooms.restore');
            Route::post('/view',[RoomCategoryController::class,'view'])->name('rooms.view');

        });


        // Create Room -start
        Route::group(['prefix'=>'ourroom'],function(){
            Route::post('/form',[OurRoomController::class,'form'])->name('ourroom.form');
            Route::get('/',[OurRoomController::class,'index'])->name('ourroom');
            Route::post('/save',[OurRoomController::class,'save'])->name('ourroom.save');
            Route::post('/list',[OurRoomController::class,'list'])->name('ourroom.list');
            Route::post('/deletefeatureimage',[OurRoomController::class,'deleteFeatureImage'])->name('ourroom.deletefeatureimage');
            Route::post('/delete',[OurRoomController::class,'delete'])->name('ourroom.delete');
            Route::post('/view',[OurRoomController::class,'view'])->name('ourroom.view');
        });
        // Create Room -end

        /* Site settings - start */
        Route::group(['prefix' => 'sitesetting'], function () {
            Route::get('/', [SiteSettingController::class, 'siteSetting'])->name('sitesetting');
            Route::post('/update', [SiteSettingController::class, 'updateSiteSetting'])->name('sitesetting.update');
        });
        /** Site settings - end */

            /* Our Team member-start*/
        Route::group(['prefix' => 'member'], function () {
            Route::get('/', [TeamMemberController::class, 'index'])->name('member');
            Route::post('/save', [TeamMemberController::class, 'save'])->name('member.save');
            Route::any('/form', [TeamMemberController::class, 'form'])->name('member.form');
            Route::post('/list', [TeamMemberController::class, 'list'])->name('member.list');
            Route::post('/delete', [TeamMemberController::class, 'delete'])->name('member.delete');
            Route::post('/restore', action: [TeamMemberController::class, 'restore'])->name('member.restore');
            Route::post('/view', [TeamMemberController::class, 'view'])->name('member.view');
         });
            /* Our team member-end*/

             /*Create Document */
        Route::group(['prefix'=>'document'],function(){
            Route::get('/',[DocumentController::class,'index'])->name('document');
            Route::post('/save',[DocumentController::class,'save'])->name('document.save');
            Route::post('/list', [DocumentController::class, 'list'])->name('document.list');
            Route::post('/delete',[DocumentController::class,'delete'])->name('document.delete');
            Route::post('/restore',[DocumentController::class,'restore'])->name('document.restore');

        });
        /*Create Document - end */

        /*Testimonial-start */
        Route::group(['prefix' => 'testimonial'], function () {
            Route::get('/', [TestimonialController::class, 'index'])->name('testimonial');
            Route::post('/save', [TestimonialController::class, 'save'])->name('testimonial.save');
            Route::post('/list', [TestimonialController::class, 'list'])->name('testimonial.list');
            Route::post('/view', [TestimonialController::class, 'view'])->name('testimonial.view');
            Route::post('/delete', [TestimonialController::class, 'delete'])->name('testimonial.delete');
            Route::post('/restore', [TestimonialController::class, 'restore'])->name('testimonial.restore');
        });
        /*Testimonial-end */
        Route::group(['prefix' => 'faq'], function () {
            Route::get('/', [FaqController::class, 'index'])->name('faq');
            Route::post('/save', [FaqController::class, 'save'])->name('faq.save');
            Route::post('/list', [FaqController::class, 'list'])->name('faq.list');
            Route::post('/form', [FaqController::class, 'form'])->name('faq.form');
            Route::post('/view', [FaqController::class, 'view'])->name('faq.view');
            Route::post('/delete', [FaqController::class, 'delete'])->name('faq.delete');
            Route::post('/restore', [FaqController::class, 'restore'])->name('faq.restore');

        /* create user faq-category - start */
        Route::group(['prefix' => 'category'], function () {
            Route::get('/', [FaqCategoryController::class, 'index'])->name('faq.category');
            Route::post('/list', [FaqCategoryController::class, 'list'])->name('faq.category.list');
            Route::post('/save', [FaqCategoryController::class, 'save'])->name('faq.category.save');
            Route::post('/delete', [FaqCategoryController::class, 'delete'])->name('faq.category.delete');
            Route::post('/restore', [FaqCategoryController::class, 'restore'])->name('faq.category.restore');
        });
        /* create user faq-category - end */
        });

            /* About us - start */
        Route::group(['prefix' => 'aboutus'], function () {
            Route::get('/', [AboutUsController::class, 'aboutUs'])->name('aboutus');
            Route::post('/update', [AboutUsController::class, 'updateAboutUs'])->name('aboutus.update');
        });
        /* About us - end */

        /* Why To Choose Us - start */
        Route::group(['prefix' => 'why-to-choose-us'], function () {
            Route::get('/', [WhyToChooseUsController::class, 'index'])->name('why.to.choose.us');
            Route::post('/getlist', [WhyToChooseUsController::class, 'getlist'])->name('why.to.choose.us.getlist');
            Route::post('/save', [WhyToChooseUsController::class, 'save'])->name('why.to.choose.us.save');
            Route::post('/view', [WhyToChooseUsController::class, 'view'])->name('why.to.choose.us.view');
            Route::post('/delete', [WhyToChooseUsController::class, 'delete'])->name('why.to.choose.us.delete');
            Route::post('/restore', [WhyToChooseUsController::class, 'restore'])->name('why.to.choose.us.restore');
        });
        /* Why To Choose Us - end */

        /* Our-values -start */
        Route::group(['prefix' => 'our-values'], function () {
            Route::get('/', [OurValueController::class, 'index'])->name('values');
            Route::post('/save', [OurValueController::class, 'save'])->name('values.save');
            Route::post('/list', [OurValueController::class, 'list'])->name('values.list');
            Route::post('/view', [OurValueController::class, 'view'])->name('values.view');
            Route::post('/delete', [OurValueController::class, 'delete'])->name('values.delete');
            Route::post('/restore', [OurValueController::class, 'restore'])->name('values.restore');
        });
        /*Our-values -end */

         //message start here
         Route::group(['prefix' => 'message'], function () {
            Route::get('/', [MessageController::class, 'index'])->name('message');
            Route::post('/list', [MessageController::class, 'list'])->name('message.list');
            Route::post('/save', [MessageController::class, 'save'])->name(name: 'message.save');
            Route::post('/delete', [MessageController::class, 'delete'])->name('message.delete');
            Route::post('/restore', [MessageController::class, 'restore'])->name('message.restore');
            Route::post('/view', [MessageController::class, 'view'])->name('message.view');
            Route::any('/form', action: [MessageController::class, 'form'])->name(name: 'message.form');
        });
        //message end here

        /*Post=> News/Notice/Article/Events-start*/
        Route::group(['prefix' => 'post'], function () {
            Route::get('/', [PostController::class, 'index'])->name('post');
            Route::post('/save', [PostController::class, 'save'])->name('post.save');
            Route::any('/form', [PostController::class, 'form'])->name('post.form');
            Route::post('/list', [PostController::class, 'list'])->name('post.list');
            Route::post('/view', [PostController::class, 'view'])->name('post.view');
            Route::post('/delete', [PostController::class, 'delete'])->name('post.delete');
            Route::post('/restore', [PostController::class, 'restore'])->name('post.restore');
            Route::post('/deletefeatureimage', [PostController::class, 'deleteFeatureImage'])->name('post.deletefeatureimage');
        });
        /*post=> News/Notice/Article/Events-end*/

        // RoomCollection starts here 
        Route::group(['prefix'=>'room'], function (){
            Route::post('/save',[RoomController::class,'save'])->name('room.save');
            Route::post('/list',[RoomController::class,'list'])->name('room.list');
            Route::post('/delete',[RoomController::class,'delete'])->name('room.delete');
            Route::post('/restore',[RoomController::class,'restore'])->name('room.restore');

        });

              /*RoomAmenities*/
        Route::group(['prefix'=>'room-setting'],function(){
            Route::get('/',[RoomAmenitiesController::class,'index'])->name('room-setting');
            Route::post('/send', [RoomAmenitiesController::class, 'loadTab'])->name('room-setting.send');
            Route::post('/list',[RoomAmenitiesController::class, 'list'])->name('room-setting.list');
            Route::post('/save',[RoomAmenitiesController::class,'save'])->name('room-setting.save');

        });

        Route::group(['prefix'=>'price-setting'],function(){
            Route::get('/',[SeasonController::class,'index'])->name('price-setting');
            Route::post('/tab',[SeasonController::class,'loadTab'])->name('price-setting.tab');
            Route::post('/save',[SeasonController::class,'save'])->name('price-setting.save');
        });
       
    });
});

