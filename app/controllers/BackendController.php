<?php

class BackendController extends BaseController {

    public function store_streak()
    {
        $days = DB::table('summaries')
            ->select(['date', 'close', 'symbol'])
            ->where('symbol', 'ABC')
            ->orderBy('date', 'desc')
            ->get();

        $streak = 0;
        $iteration_price = null;

        for ($i = 0; $i < count($days); $i++)
        {
            // if the next days price is the same as the current, the streak is over
            if ($days[$i + 1]->close === $days[$i]->close)
            {
                break;
            }

            // if it's not the first iteration, check if the streak is over or not
            if (! is_null($iteration_price))
            {
                if ($streak > 0 && $days[$i + 1]->close > $iteration_price)
                {
                    // winning streak is over
                    break;
                }
                elseif ($streak < 0 && $days[$i + 1]->close < $iteration_price)
                {
                    // losing streak is over
                    break;
                }
            }

            if ($days[$i + 1]->close > $days[$i]->close) // on a losing streak
            {
                $streak--;
                pp('subtracting 1. streak is: ' . $streak);

                // update iteration price with new value
                $iteration_price = $days[$i + 1]->close;
            }
            elseif ($days[$i + 1]->close < $days[$i]->close) // on a winning streak
            {
                $streak++;
                pp('adding 1. streak is: ' . $streak);

                // update iteration price with new value
                $iteration_price = $days[$i + 1]->close;
            }
            else
            {
                throw new Exception("Problem with closing summary data. Stock: " . $days[$i]->symbol);
            }
        }
        pp('The streak is: ' . $streak);
    }

    public function store_historical_data()
    {
        $files = File::files(app_path() . '/resources/historical_lists');

        $daily_summaries = [];

        foreach ($files as $file)
        {
            $handle = fopen($file, "r");

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
        }

        Summary::truncate();

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

        return 'done';
    }

}
