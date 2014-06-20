<?php

// Homepage
Route::get('/', 'StockController@index');

// AJAX routes
Route::get('ajax/stock_data', 'AjaxController@stock_data');