<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;
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

// All Listings
Route::get('/', [ListingController::class, 'index']);

Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// Store Listing Data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');


// Show Edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Edit Submit to Update
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Delete Listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');




// Show Login
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

Route::post('/users/authenticate', [UserController::class , 'authenticate']);

// Show Register 
Route::get('/register', [UserController::class , 'create'])->middleware('guest');

// Create User 
Route::post('/users', [UserController::class, 'store']);

// Logout
Route::post('/logout', [UserController::class , 'logout'])->middleware('auth');

// Manage Listings
Route::get('/listings/manage', [ListingController::class , 'manage'])->middleware('auth');


// Single Listing /should be at the bottom because the {} means a place holder that accepts all the options like create
Route::get('/listings/{listing}', [ListingController::class, 'show']);
/* Route::get('/hello', function(){
    return response('<h1>Hello World<h1>', 200)->header('Content-Type', 'text/plain')->header('foo', 'bar');
});

Route::get('/posts/{id}', function($id){
    // die dump
    // dd($id);
    // die dump debug
    // ddd($id);
    return response('Post'.$id);
})->where('id', '[0-9]+');

Route::get('/search', function(Request $request){
    // dd($request->name. ' '.$request->lastname);
    return($request->name. ' '.$request->lastname);
}); */