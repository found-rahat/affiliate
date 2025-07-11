<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AddCartController;
use App\Http\Controllers\CustomerInfoController;
use App\Http\Controllers\OrderNowController;
use App\Http\Controllers\OrderInfoController;
use App\Http\Controllers\OrderListController;

// Route::get('/', function () {
//     return view('/dashboard');
// });


Route::group(['middleware'=>'guest'],function(){
    Route::get('/login',[LoginController::class,'index'])->name('user.login');
    Route::post('/authenticate',[LoginController::class,'authenticate'])->name('user.authenticate');
    Route::post('/process-register',[LoginController::class,'processRegister'])->name('user.processRegister');
    Route::get('/register',[LoginController::class,'register'])->name('user.register');
});

Route::group(['middleware'=>'auth'],function(){
    Route::get('/logout',[LoginController::class,'logout'])->name('user.logout');
    Route::get('/',[LoginController::class,'dashboard'])->name('user.dashboard');


    Route::get('/blank',[LoginController::class,'blank'])->name('user.blank');
    Route::get('/charge',[LoginController::class,'charge'])->name('user.charge');
    Route::get('/howtowork',[LoginController::class,'howtowork'])->name('user.howtowork');
    Route::get('/payment',[LoginController::class,'payment'])->name('user.payment');
    Route::get('/product',[LoginController::class,'product'])->name('user.product');
    Route::get('/track',[LoginController::class,'track'])->name('user.track');

    //----------------Report------------
    Route::get('/reportsview', [ReportController::class, 'viewReport'])->name('user.reportsview');
    Route::get('/report',[ReportController::class,'index'])->name('user.report');
    Route::get('/report', [ReportController::class, 'reportPage'])->name('user.report');
    Route::Post('/report/authenticate',[ReportController::class,'authenticate'])->name('report.authenticate');



    //------------about us-------------------------
    Route::get('/about',[AboutUsController::class,'index'])->name('user.about');
    Route::get('/about',[AboutUsController::class,'aboutus'])->name('user.about');



    //-----------------add to cart and order now------------------------
    Route::get('/ordernow',[OrderNowController::class,'ordernow'])->name('user.ordernow');
    Route::get('/productview',[OrderNowController::class,'productview'])->name('user.productview');
    Route::post('/productview',[OrderNowController::class,'addtocard'])->name('user.addtocard');
    Route::post('/addtocard',[OrderNowController::class,'addviewclick'])->name('user.addviewclick');
    Route::get('/addtocard',[OrderNowController::class,'buynow'])->name('user.clickicon');
    Route::post('/ordernow/update', [OrderNowController::class, 'updateCart'])->name('user.cart.update');
    Route::get('/addcard/delete/{id}', [OrderNowController::class, 'addcarddelete'])->name('user.addcarddelete');

    //---------------------- customer order info and orderlist, item also -----------------
    Route::post('/ordernow',[CustomerInfoController::class, 'customerinsert'])->name('user.order.submit');



    //----------------------------Order info------------------------------
    Route::get('/orderinfo',[OrderInfoController::class,'index'])->name('orderinfo');
    Route::get('/prepayment',[OrderInfoController::class,'payment'])->name('prepayment');
    Route::post('/prepayment/update',[OrderInfoController::class,'prepaymentUpdate'])->name('prepaymentUpdate');
    Route::post('/customerinfo/update',[OrderInfoController::class,'customerinfoUpdate'])->name('infoUpdate');



    //-------------------------Order list----------------------

    Route::get('/orderlist',[OrderListController::class,'index'])->name('user.orderlist');








});









