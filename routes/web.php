<?php


use App\Stock;
use App\Invoice;
use App\Products;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    // return view('welcome');
    if(Auth::check())
    {
        return redirect()->route('home');
    }
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {

Route::get('/home', 'HomeController@index')->name('home');

//Product Routes
Route::get('products', 'ProductController@index')->name('products');
Route::get('pagination/fetch_data', 'ProductController@fetch_data');
Route::get('product/add-new-product', 'ProductController@addProduct')->name('product/add-new-product');
Route::post('add-product','ProductController@store')->name('add-product');
Route::get('product/edit-product/{id}', 'ProductController@edit')->name('product/edit-product');
Route::put('edit-product/{product}','ProductController@update');
Route::get('product/log/{id}','ProductController@ProductLog')->name('product/log');
Route::get('product_log_pagination/fetch_data', 'ProductController@fetch_log_data');
Route::delete('product-delete/{product}', 'ProductController@delete')->name('product-delete');
Route::delete('/selected-records','ProductController@deleteSelected')->name('dashboard.deleteSelectedProduct');

//Stock Routes
Route::get('stock', 'StockController@index')->name('stock');
Route::get('stock_pagination/fetch_data', 'StockController@fetch_log_data');
Route::get('/stock-add-quantity/{id}','StockController@addQuantity');
Route::post('/add-qty/{stock}','StockController@addStockQuantity');

//Invoice Routes
Route::get('invoice', 'InvoiceController@index')->name('invoice');
Route::get('invoice-pagination/fetch_data', 'InvoiceController@fetch_data');
Route::get('invoice/create-invoice', 'InvoiceController@createInvoiceForm')->name('invoice/create-invoice');
Route::get('/get-product-data/{id}','InvoiceController@getProductData');
Route::post('create-invoice','InvoiceController@createInvoice')->name('create-invoice');
Route::get('invoice/detail/{id}','InvoiceController@detail')->name('invoice/detail');
Route::get('invoice/summary','InvoiceController@summaryList')->name('invoice/summary');
Route::get('invoice/change-status/{invoice}','InvoiceController@changeStatus')->name('invoice/change-status');
Route::get('invoice/invoice-search','InvoiceController@searchInvoice')->name('invoice/invoice-search');
Route::get('invoice-print/{id}','InvoiceController@InvoicePrint')->name('invoice-print');
Route::delete('invoice-delete/{invoice}', 'InvoiceController@delete')->name('invoice-delete');
Route::delete('/selected-invoice-delete','InvoiceController@deleteSelected')->name('invoice.deleteSelectedInvoice');

//Payment History Routes
Route::get('invoice/payment-history/{invoice}','InvoiceController@paymentHistory')->name('invoice/payment-history');
Route::post('/add-payment-history','InvoiceController@addPaymentHistory')->name('add-payment-history');
Route::delete('/payment-history-delete/{paymentHistory}','InvoiceController@deletePaymentHistory')->name('payment-history-delete');
Route::get('/edit-payment-history-form/{id}','InvoiceController@editPaymentHistoryForm');
Route::post('/payment-history-edit','InvoiceController@updatePaymentHistory')->name('payment-history-edit');

//User Routes
Route::get('user', 'UserController@index')->name('user');
Route::get('user/add-new-user', 'UserController@addNewUser')->name('user.add');
Route::post('user/add-user','UserController@store')->name('add-user');
Route::get('user/edit-user/{user}', 'UserController@edit')->name('user/edit-user');
Route::put('edit-user/{user}','UserController@update');
Route::delete('user-delete/{user}', 'UserController@delete')->name('user-delete');
Route::get('change-profile', 'UserController@changeProfileForm');
Route::put('update-profile/{user}','UserController@updateUserProfile');


//Booker Routes
Route::post('/add-booker','BookerController@store');
Route::delete('/selected-bookers','BookerController@deleteCheckedBooker')->name('deleteSelectedRoles');

//Sales Report Route
Route::get('sales-report','SalesReportController@index')->name('sales-report');

});