<?php

// ini_set("memory_limit", "-1");
// set_time_limit(0);

Route::get('/', 'StockController@index');

// Routes for fetching data
Route::get('fetch', 'FetchingController@fetch_stock_data');
Route::get('fetch_historical', 'FetchingController@fetch_stock_history');

// Routes for storing data
Route::get('store_streak', 'StoringController@store_streak');
Route::get('store_historical', 'StoringController@store_stock_history');
Route::get('store_summary', 'StockController@store_stock_summary');


// AJAX routes
Route::get('ajax/stock_data', 'AjaxController@stock_data');