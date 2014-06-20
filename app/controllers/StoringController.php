<?php

class StoringController extends BaseController {

    public function __construct()
    {
        ini_set("memory_limit", "-1");
        set_time_limit(0);
    }

    public function store_streaks()
    {
        $date = date('Y-m-d');

        $stocks = DB::table('stocks')->select('symbol')->orderBy('symbol', 'asc')->get();

        foreach ($stocks as $stock)
        {
            $stored = DB::table('stocks')
                ->where('symbol', $stock->symbol)
                ->where('streak_stored', $date)
                ->first();

            if ($stored) continue;
                
            $days = DB::table('summaries')
                ->select('close')
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

            DB::table('stocks')
                ->where('symbol', $stock->symbol)
                ->update([
                    'streak' => $streak,
                    'streak_stored' => $date,
                ]);

            print "Stored a streak of " . $streak . " for: " . $stock->symbol . "\n";
        }
    }

    public function store_stock_summary()
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

    // This function will insert 20 million rows into DB! Sweet!
    public function store_stock_history()
    {
        $date = date('Y-m-d');

        set_time_limit(0);

        $files = File::files(app_path() . '/resources/historical_lists');

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

                // insert into summaries array provided its not the header
                if ($summary[0] !== 'Date')
                {
                    // validate the array by checking if it has 8 elements
                    if (count($summary) == 7)
                    {
                        DB::table('summaries_demo')->insert([
                            'date'   => $summary[0],
                            'symbol' => $symbol,
                            'open'   => $summary[1],
                            'high'   => $summary[2],
                            'low'    => $summary[3],
                            'close'  => $summary[4],
                            'adjusted_close' => $summary[6],
                            'volume' => $summary[5],
                            'updated_at' => new Datetime,
                        ]);

                        print "Inserted: " . $symbol . ". Date: " . $summary[0] . PHP_EOL;
                    }
                }
            }

            fclose($handle);

            DB::table('stocks')
                ->where('symbol', $symbol)
                ->update([
                    'history_updated' => $date,
                ]);
        }
    }

}
