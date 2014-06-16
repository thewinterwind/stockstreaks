<?php

class StockController extends BaseController {

    public function index()
    {
        $data['title'] = 'Current Stock Winning and Losing Streaks for NYSE, Nasdaq and AMEX';
        $data['description'] = 'Find the hottest and coldest stocks on top stock exchanges, absolutely free!';
        $data['header'] = 'Winning and Losing Streaks for NYSE, Nasdaq and AMEX stocks';

        return View::make('stocks.index', $data);
    }

    public function store()
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
                    'symbol' => $stock[0],
                    'name' => $stock[1],
                    'exchange' => $stock[9],
                    'ipo_year' => $stock[5],
                    'sector' => $stock[6],
                    'industry' => $stock[7],
                    'last_sale' => $stock[2],
                    'market_cap' => $stock[3],
                    'summary_link' => $stock[8],
                    'updated_at' => new Datetime,
                ]
            );

            echo 'created stock: ' . $row->id  . PHP_EOL;
        }
    }

}
