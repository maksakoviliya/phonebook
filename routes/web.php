<?php

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

Route::get('/', 'PagesController@home')->name('home');

Auth::routes();

// Route::prefix('api')->group(function () {
  
// });

Route::middleware(['isadmin'])->group(function () {
  // Route::get('/dashboard', 'PagesController@index')->name('dashboard');
  Route::get('/dashboard', function () {
      return redirect()->route('phonebooks.index');
  })->name('dashboard');
  Route::resource('/phonebooks', 'PhoneBookController')->names('phonebooks');
  Route::get('/phonebooks/{phonebookId}/contacts', 'PhoneBookController@contacts')->name('phonebooks.contacts');
  Route::resource('/contacts', 'ContactController')->names('contacts');
  Route::resource('/customers', 'CustomerController')->names('customers');
  Route::resource('/users', 'UserController')->names('users');

  Route::get('/api/phonebooks/{id?}', 'PhoneBookController@all')->name('phonebooks.all');
  Route::get('/api/search/phonebooks', 'PhoneBookController@search')->name('phonebooks.search');
  Route::get('/api/search/customers', 'CustomerController@search')->name('customers.search');
  Route::get('/api/search/users', 'UserController@search')->name('users.search');
  Route::get('/api/search/contacts', 'ContactController@search')->name('contacts.search');
  
  Route::post('codes/create', 'CodeController@create')->name('codes.create');
});
