<?php

class FetchingController extends BaseController {

public function fetch_stock_data()
{
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
}

public function fetch_stock_history()
{
    ini_set("memory_limit", "-1");
    set_time_limit(0);

    $stocks = DB::table('stocks')
        ->select('symbol')
        ->where('symbol', 'NOT LIKE', '%^%')
        ->where('symbol', 'NOT LIKE', '%/%')
        ->orderBy('symbol', 'asc')
        ->get();

    foreach ($stocks as $stock) {
        if ( ! file_exists(app_path() . '/resources/lists_demo/' . $stock->symbol . '.csv'))
        {
            try {
                $stock_data = file_get_contents('http://ichart.finance.yahoo.com/table.csv?s=' . $stock->symbol);
            } catch (Exception $e) {
                print $e->getMessage() . EOL;
            }

            $bytes = file_put_contents(
                app_path() . '/resources/lists_demo/' . $stock->symbol . '.csv', 
                $stock_data
            );
            
            if ($bytes) print 'Stored csv for: ' . $stock->symbol . ' (' . $bytes .  ' bytes)' . PHP_EOL;

            DB::table('stocks')
                ->where('symbol', $stock->symbol)
                ->update(['history_updated' => new Date('Y-m-d')]);
        }
    }
}

} // end class