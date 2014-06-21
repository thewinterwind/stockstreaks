<?php namespace SS\Stock;

use DB, File, Cache;

class Stock {

    public function __construct()
    {
        ini_set("memory_limit", "-1");
        set_time_limit(0);
    }

    /**
     * Update the stock streaks after the market has closed
     *
     * @param $overwrite (whether to update all data from beginning)
     * @return void
     */

    public function updateStreaks($overwrite = false)
    {
        $date = DB::table('summaries')
                ->select('date')
                ->orderBy('date', 'desc')
                ->limit(1)
                ->first()->date;

        $stocks = DB::table('stocks')->select('symbol')->orderBy('symbol', 'asc')->get();

        foreach ($stocks as $stock)
        {
            $stored = DB::table('stocks')
                ->where('symbol', $stock->symbol)
                ->where('streak_stored', $date)
                ->first();

            if ($stored && !$overwrite) continue;
                
            $days = DB::table('summaries')
                ->select('close', 'volume')
                ->where('symbol', $stock->symbol)
                ->orderBy('date', 'desc')
                ->limit(20)
                ->get();

            $streak = 0;

            for ($i = 0; $i < count($days); $i++)
            {
                // if we're at the earliest day recorded for a stock, the streak is over
                if ( ! isset($days[$i + 1])) break;

                // if the next days price is the same as the current, the streak is over
                if ($days[$i]->close === $days[$i + 1]->close) break;

                // one time check for the first iteration
                if ($i === 0)
                {
                    if ($days[$i] > $days[$i + 1])
                    {
                        $streak++; continue;
                    }

                    if ($days[$i] < $days[$i + 1])
                    {
                        $streak--; continue;
                    }
                }

                // check if the winning streak is over or not
                if ($streak > 0)
                {
                    // if current day's close is less than the day before it, the winning streak is over
                    if ($days[$i]->close < $days[$i + 1]->close) break;
                    
                    // the winning streak continues
                    $streak++;
                }
                elseif ($streak < 0)
                {
                    // if the current day's close is more than the day before it, the losing streak is over
                    if ($days[$i]->close > $days[$i + 1]->close) break;
                    
                    // the losing streak continues
                    $streak--;
                }
            }

            $amount = $this->calculateMovePercentage($days, $streak);

            $volume = $this->calculateStreakVolume($days, $streak);

            DB::table('stocks')
                ->where('symbol', $stock->symbol)
                ->update([
                    'streak' => $streak,
                    'move_percentage' => $amount,
                    'streak_volume' => $volume,
                    'streak_stored' => $date,
                ]);

            print "Symbol: " . $stock->symbol . " # Streak: " . $streak . " # ";
            print "Amount: " . $amount        . " # Volume: " . $volume . "\n";
        }

        print "Done storing streaks for closing date: " . $date;
    }

    /**
     * Update the stock streaks after the market has closed
     *
     * @param  array $days (daily summaries)
     * @param  int   $days (streak)
     * @return int         (shares traded volume)
     */

    public function calculateStreakVolume(array $days, $streak)
    {
        $daysOnStreak = array_slice($days, 0, abs($streak));

        $volume = 0;

        foreach ($daysOnStreak as $day) {
            $volume += $day->volume;
        }

        return $volume;
    }

    /**
     * Get the percentage the stock moved over the streak's duration
     *
     * @param  array  $days (daily summaries)
     * @param  int    $days (streak)
     * @return double       (move percentage)
     */

    public function calculateMovePercentage(array $days, $streak)
    {
        if ($streak == 0) return 0;

        $days = array_slice($days, 0, abs($streak) + 1);

        return round(($days[0]->close / end($days)->close - 1) * 100, 2);
    }

    /**
     * Store basic information about a stock
     *
     * @return void
     */

    public function storeStockInfo()
    {
        $files = File::files(app_path() . '/resources/stock_lists');

        $stocks = [];

        foreach ($files as $file)
        {
            $handle = fopen($file, "r");

            while( ! feof($handle))
            {
                $stock = fgetcsv($handle);

                $stock[9] = basename($file, '.csv');

                if (count($stock) == 10)
                {
                    $stocks[] = $stock;
                }
            }

            fclose($handle);
        }

        echo count($stocks) . ' to create' . PHP_EOL;

        foreach ($stocks as $stock)
        {
            $row = Stock::create(
                [
                    'symbol' => remove_whitespace($stock[0]),
                    'name' => $stock[1],
                    'exchange' => remove_whitespace($stock[9]),
                    'ipo_year' => remove_whitespace($stock[5]),
                    'sector' => $stock[6],
                    'industry' => remove_whitespace($stock[7]),
                    'last_sale' => remove_whitespace($stock[2]),
                    'market_cap' => remove_whitespace($stock[3]),
                    'summary_link' => remove_whitespace($stock[8]),
                    'updated_at' => new Datetime,
                ]
            );

            echo 'created stock: ' . $row->id  . PHP_EOL;
        }
    }

    public function store_stock_history()
    {
        $date = date('Y-m-d');

        $files = File::files(app_path() . '/resources/historical_lists/' . $date);

        $completed_stocks = DB::table('stocks')
            ->select('symbol')
            ->where('history_updated', $date)
            ->groupBy('symbol')
            ->orderBy('symbol', 'asc')
            ->get();

        $completed_symbols = array_pluck($completed_stocks, 'symbol');

        foreach ($files as $file)
        {
            $symbol = basename($file, '.csv');

            if (in_array($symbol, $completed_symbols)) continue;

            $handle = fopen($file, "r");

            while( ! feof($handle))
            {
                // the stock's daily summary (closing price, volume, etc.)
                $summary = fgetcsv($handle);

                // 1. continue to next iteration if it's the header
                // 2. continue to next iteration if there isn't seven elements (invalid record)
                if ($summary[0] == 'Date' || count($summary) !== 7) continue;

                // if the date is less than today, we've already stored it, break out of the loop
                if (remove_whitespace($summary[0]) < $date) break;

                DB::table('summaries')->insert([
                    'date'   => remove_whitespace($summary[0]),
                    'symbol' => remove_whitespace($symbol),
                    'open'   => remove_whitespace($summary[1]),
                    'high'   => remove_whitespace($summary[2]),
                    'low'    => remove_whitespace($summary[3]),
                    'close'  => remove_whitespace($summary[4]),
                    'adjusted_close' => remove_whitespace($summary[6]),
                    'volume' => remove_whitespace($summary[5]),
                    'updated_at' => new Datetime,
                ]);

                print "Inserted: " . $symbol . ". Date: " . $summary[0] . PHP_EOL;
            }

            fclose($handle);

            DB::table('stocks')
                ->where('symbol', $symbol)
                ->update([
                    'history_updated' => $date,
                ]);

            print "--------------------------------". PHP_EOL;
            print "Finished inserting for: " . $symbol . PHP_EOL;
            print "--------------------------------". PHP_EOL;
        }
    }

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
        $date = date('Y-m-d');

        $stocks = DB::table('stocks')
            ->select('symbol')
            ->where('symbol', 'NOT LIKE', '%^%') // some stocks have ^ in them (not doing these now)
            ->where('symbol', 'NOT LIKE', '%/%') // some stocks have / in them (not doing these now)
            ->where('history_downloaded', '!=', $date)
            ->orderBy('symbol', 'asc')
            ->get();

        $target_dir = app_path() . '/resources/' . $date;

        if ( ! is_dir($target_dir)) mkdir($target_dir, 0755);

        foreach ($stocks as $stock)
        {
            $symbol = $stock->symbol;
            
            $stock_data = @file_get_contents('http://ichart.finance.yahoo.com/table.csv?s=' . $stock->symbol);

            if ($stock_data)
            {
                $bytes = file_put_contents(
                    $target_dir . '/' . remove_whitespace($stock->symbol) . '.csv', 
                    $stock_data
                );

                if ($bytes)
                {
                    print 'Stored csv for: ' . $stock->symbol . ' (' . $bytes .  ' bytes)' . PHP_EOL;

                    // store the date to confirm it was downloaded
                    // if the script fails midway we can pick up from last time
                    DB::table('stocks')
                        ->where('symbol', $stock->symbol)
                        ->update([
                            'history_downloaded' => $date
                        ]);
                }
            }
        }
    }

}
