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

Route::POST("/MasterPeraturan", "peraturanControl@index");
Route::POST("/Masterberita", "beritaControl@index");
Route::POST("/MasterKategori", "kategoriControl@index");
Route::POST("/MasterSubKategori", "subKategoriControl@index");
Route::POST("/MasterVideos", "videosControl@index");

Route::GET("/login", "appControl@login");
Route::POST("/login/loginSubmit", "appControl@loginSubmit");
Route::get("/logout", "appControl@logout");


Route::get("/{any}", "appControl@index")->where("any", ".*");
