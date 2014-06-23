<?php

// Homepage
Route::get('/', 'StockController@index');

// Check daily stock information
Route::get('fetch', 'StockController@fetchStockData');

// See daily stock information
Route::get('peek', 'StockController@seeStockData');

// AJAX routes
Route::get('ajax/stock_data', 'AjaxController@fetchStockData');