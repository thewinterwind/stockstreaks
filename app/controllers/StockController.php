<?php

class StockController extends BaseController {

	public function store()
	{
        // CSV lists from http://www.nasdaq.com/screening/company-list.aspx
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

        echo count($stocks) . ' to create<br/>';

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

            echo 'created stock: ' . $row->id . '<br/>';
        }
    }

}
