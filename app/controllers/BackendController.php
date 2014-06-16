<?php

class BackendController extends BaseController {

    public function store_streak()
    {
        $stocks = DB::table('stocks')->select('symbol')->get();

        foreach ($stocks as $stock)
        {
            $days = DB::table('summaries')
                ->select(['date', 'close', 'symbol'])
                ->where('symbol', $stock->symbol)
                ->orderBy('date', 'desc')
                ->limit(20)
                ->get();

            $streak = 0;
            $iteration_price = null;

            for ($i = 0; $i < count($days); $i++)
            {
                // if the next days price is the same as the current, the streak is over
                if ($days[$i + 1]->close === $days[$i]->close) break;

                // if it's not the first iteration, check if the streak is over or not
                if (! is_null($iteration_price))
                {
                    if ( $streak > 0 && $days[$i + 1]->close > $iteration_price ||
                         $streak < 0 && $days[$i + 1]->close < $iteration_price
                    ) break;
                }

                if ($days[$i + 1]->close > $days[$i]->close)
                {
                    // the losing streak continues
                    $streak--;
                }
                elseif ($days[$i + 1]->close < $days[$i]->close)
                {
                    // the winning streak continues
                    $streak++;
                }

                // store the next's days closing price
                // on the following iteration, this price will be the current day price
                // and we will compare against the new next day price
                $iteration_price = $days[$i + 1]->close;
            }

            Stock::where('symbol', $stock->symbol)->update([
                'streak' => $streak,
                'updated_at' => new Datetime,
            ]);
        }
    }

    public function store_historical_data()
    {
        $files = File::files(app_path() . '/resources/historical_lists');

        $summaries = DB::table('summaries')->select('symbol')->groupBy('symbol')->get();

        $symbols = array_pluck($summaries, 'symbol');

        foreach ($files as $file)
        {
            $symbol = basename($file, '.csv');

            if (in_array($symbol, $symbols)) continue;

            $handle = fopen($file, "r");

            // reset the stocks summaries array with each iteration
            $daily_summaries = [];

            while( ! feof($handle))
            {
                $daily_summary = fgetcsv($handle);

                // insert into summaries array provided its not the header
                if ($daily_summary[0] !== 'Date')
                {
                    $daily_summary[7] = basename($file, '.csv');
                    $daily_summaries[] = $daily_summary;
                }
            }

            fclose($handle);
    
            foreach($daily_summaries as $summary)
            {
                // validate the array by checking if it has 8 elements
                if (count($summary) == 8)
                {
                    Summary::create(
                        [
                            'date'   => $summary[0],
                            'symbol' => $summary[7],
                            'open'   => $summary[1],
                            'high'   => $summary[2],
                            'low'    => $summary[3],
                            'close'  => $summary[4],
                            'adjusted_close' => $summary[6],
                            'volume' => $summary[5],
                            'updated_at' => new Datetime,
                        ]
                    );
                }
            }
            print 'Stored historical data for: ' . $symbol . PHP_EOL;
        }

        return 'done';
    }

}
