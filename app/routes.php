<?php

Route::get('fetch', function() {
    // fetch stock from query string
    $stock = Input::get('stock');

    // cache key is a unique string of resource type, date, and resource id
    $cache_key = 'stock_data' . date('Y-m-d') . $stock;

    // build query at https://developer.yahoo.com/yql/console/
    if ( ! Cache::has($cache_key) ) {
        $resource = "https://query.yahooapis.com/v1/public/yql?q=";
        $resource .= urlencode("select * from yahoo.finance.quotes ");
        $resource .= urlencode("where symbol in ('$stock')");
        $resource .= "&format=json&diagnostics=true";
        $resource .= "&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=";

        // fetch the json
        try {
            $data = json_decode(file_get_contents($resource));
        } catch (Exception $e) {
            $data = ['error' => $e->getMessage()];
        }

        // cache for a day
        Cache::put($cache_key, $data, 60 * 24);
    }

    // pretty print data
    pp( Cache::get($cache_key) );
});

Route::get('/', function() {
    return View::make('stocks.index');
});

Route::get('store_stocks', 'StockController@create');

    $path = app_path() . '/resources/stock_lists/Nasdaq.csv';

    $file = fopen($path, "r");

    $stocks = [];

    while(! feof($file)) {
        $stock = fgetcsv($file);
        unset($stock[9]);
        
        $stocks[] = $stock;
    }

    pp($stocks);

    fclose($file);
});


