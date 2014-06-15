<?php

class StockController extends BaseController {

	public function create()
	{
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
    }

}
