<?php

use SS\Stock\Stock;

class StockController extends Controller {

    public function index()
    {
        $data['title'] = 'Current Stock Winning and Losing Streaks for NYSE, Nasdaq and AMEX';
        $data['description'] = 'Find the hottest and coldest stocks on top stock exchanges, absolutely free!';
        $data['header'] = 'Winning and Losing Streaks for NYSE, Nasdaq and AMEX stocks';

        return View::make('stocks.index', $data);
    }

    public function fetchStockData()
    {
        return (new Stock)->{__FUNCTION__}();
    }

}
