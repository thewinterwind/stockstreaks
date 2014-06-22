<?php

// Homepage
Route::get('/', 'StockController@index');

// Check daily stock information
Route::get('fetch', 'StockController@fetchStockData');

// AJAX routes
Route::get('ajax/stock_data', 'AjaxController@fetchStockData');