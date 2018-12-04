<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', 'TriadLtd\ArrayFiles\Http\Controllers\ArrayFilesController@index');
Route::post('/upload', 'TriadLtd\ArrayFiles\Http\Controllers\ArrayFilesController@upload');
Route::delete('/delete/{file}', 'TriadLtd\ArrayFiles\Http\Controllers\ArrayFilesController@delete');
