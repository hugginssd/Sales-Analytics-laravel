<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Auth::routes();
//============================

//--Auth
Route::group(['namespace' => 'Auth', 'prefix' => 'member'], function ($router) {
    $router->get('/login.html', 'LoginController@showLoginForm')->name('login');
    $router->post('/login.html', 'LoginController@login')->name('postLogin');
    $router->get('/register.html', 'LoginController@showLoginForm')->name('register');
    $router->post('/register.html', 'RegisterController@register')->name('postRegister');
    $router->post('/logout', 'LoginController@logout')->name('logout');
    $router->post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $router->post('/password/reset', 'ResetPasswordController@reset');
    $router->get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    $router->get('/forgot.html', 'ForgotPasswordController@showLinkRequestForm')->name('forgot');
});
//End Auth

//Customer profile
Route::group(['prefix' => 'member', 'middleware' => 'auth'], function ($router) {
    $router->get('/', 'ShopAccount@index')->name('member.index');
    $router->get('/order_list.html', 'ShopAccount@orderList')->name('member.order_list');
    $router->get('/change_password.html', 'ShopAccount@changePassword')->name('member.change_password');
    $router->post('/change_password.html', 'ShopAccount@postChangePassword')->name('member.post_change_password');
    $router->get('/change_infomation.html', 'ShopAccount@changeInfomation')->name('member.change_infomation');
    $router->post('/change_infomation.html', 'ShopAccount@postChangeInfomation')->name('member.post_change_infomation');
});
//End customer

//Language
Route::get('locale/{code}', function ($code) {
    session(['locale' => $code]);
    return back();
})->name('locale');

//Currency
Route::get('currency/{code}', function ($code) {
    session(['currency' => $code]);
    return back();
});

//========Cart
Route::get('/wishlist.html', 'ShopCart@wishlist')->name('wishlist');
Route::get('/compare.html', 'ShopCart@compare')->name('compare');
Route::get('/cart.html', 'ShopCart@getCart')->name('cart');
Route::post('/cart.html', 'ShopCart@addToCart')->name('cart.add');
Route::get('/checkout.html', 'ShopCart@getCheckout')->name('checkout');
Route::post('/checkout.html', 'ShopCart@processCart')->name('checkout.prepare');
Route::get('/removeItem/{id}', 'ShopCart@removeItem')->name('cart.remove');
Route::get('/removeItemWishlist/{id}', 'ShopCart@removeItemWishlist')->name('wishlist.remove');
Route::get('/removeItemCompare/{id}', 'ShopCart@removeItemCompare')->name('compare.remove');
Route::get('/clearCart', 'ShopCart@clearCart')->name('cart.clear');
Route::post('/addToCartAjax', 'ShopCart@addToCartAjax')->name('cart.add_ajax');
Route::post('/updateToCart', 'ShopCart@updateToCart')->name('cart.update');
Route::post('/addOrder', 'ShopCart@addOrder')->name('addOrder');
//========End cart

//========Front
//Home
Route::get('/', 'ShopFront@index')->name('home');
Route::get('index.html', 'ShopFront@index');
//End home

//Category
Route::get('/categories', 'ShopFront@getCategories')->name('categories');
Route::get('/category/{name}_{id}', 'ShopFront@productToCategory')
    ->where(['id' => '[0-9]+'])->name('category');
//End category

//Brand
Route::get('/brands', 'ShopFront@getBrands')->name('brands');
Route::get('/brand/{name}_{id}', 'ShopFront@productToBrand')
    ->where(['id' => '[0-9]+'])->name('brand');
//End brand

//Vendor
Route::get('/vendors', 'ShopFront@getVendors')->name('vendors');
Route::get('/vendor/{name}_{id}', 'ShopFront@productToVendor')
    ->where(['id' => '[0-9]+'])->name('vendor');
//End vendor

//Product
Route::get('/products.html', 'ShopFront@allProducts')->name('product.all');
Route::post('/productInfo', 'ShopFront@productInfo')->name('product.info');
Route::get('/product/{name}_{id}.html', 'ShopFront@productDetail')
    ->where(['id' => '[0-9]+'])->name('product.detail');
//End product

Route::get('/search.html', 'ShopFront@search')->name('search');
Route::post('/subscribe', 'ShopFront@emailSubscribe')->name('subscribe');
//Content
Route::get('/contact.html', 'ContentFront@getContact')->name('contact');
Route::post('/contact.html', 'ContentFront@postContact')->name('postContact');
Route::get('/news.html', 'ContentFront@news')->name('news');
Route::get('/news/{name}_{id}.html', 'ContentFront@newsDetail')
    ->where(['id' => '[0-9]+'])->name('newsDetail');

//--Please keep 2 lines route (pages + pageNotFound) at the bottom
Route::get('/{key}.html', 'ContentFront@pages')->name('pages');
// Route::fallback('ShopFront@pageNotFound')->name('pageNotFound'); //Make sure before using this route. There will be disadvantages when detecting 404 errors for static files like images, scripts ..
//--end keep

//=======End Front
