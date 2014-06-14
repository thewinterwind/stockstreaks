<?php

Route::get('fetch', function()
{
    // fetch stock from query string
    $stock = Input::get('stock');

    $data = Cache::get('stock_data_' . date('Y-m-d') . $stock);

    if (!$data) {
        $resource = "https://query.yahooapis.com/v1/public/yql?q=";
        $resource .= urlencode("select * from yahoo.finance.quotes ");
        $resource .= urlencode("where symbol in ('$stock')");
        $resource .= "&format=json&diagnostics=true";
        $resource .= "&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=";

        // fetch the json
        try {
            $data = file_get_contents($resource);
        } catch (Exception $e) {
            $data = json_encode(['error' => $e->getMessage()]);
        }

        Cache::put('stock_data_' . date('Y-m-d') . $stock, $data, 60 * 24);
    }

    // pretty print data
    pp($data);
});

Route::get('/', function() {
    return View::make('stocks.index');
});