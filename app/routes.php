<?php

ini_set("memory_limit", "-1");
set_time_limit(0);

Route::get('fetch', 'APIController@get_stock_data');

Route::get('/', 'StockController@index');

Route::get('store', 'StockController@store');

Route::get('ajax/stock_data', 'AjaxController@stock_data');

Route::get('api/historical', 'APIController@fetch_historical_stock_data');

Route::get('backend/store_historical', 'BackendController@store_historical_data');

Route::get('backend/store_streak', 'BackendController@store_streak');