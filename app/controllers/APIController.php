<?php

class APIController extends BaseController {

	public function get_stock_data()
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

    public function fetch_historical_stock_data()
    {
        $stocks = Stock::select('symbol')->get()->toArray();

        $symbols = array_pluck($stocks, 'symbol');

        foreach ($symbols as $symbol) {
            try
            {
                if (!file_exists(app_path() . '/resources/historical_lists/' . $symbol . '.csv'))
                {
                    $csv_data = file_put_contents(
                        app_path() . '/resources/historical_lists/' . $symbol . '.csv', 
                        file_get_contents('http://ichart.finance.yahoo.com/table.csv?s=' . $symbol)
                    );
                }
            }
            catch (Exception $e)
            {
                echo 'Failed fetching csv for: ' . $symbol . '<br/>';
            }
        }
    }

}
