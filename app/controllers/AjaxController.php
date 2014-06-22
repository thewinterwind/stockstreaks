<?php

use SS\Libraries\Datatables\Datatables;

class AjaxController extends Controller {

    public function __construct(Datatables $datatables)
    {
        $this->datatables = $datatables;
    }

	public function fetchStockData()
	{
        $columns = [
            [
                'db' => 'streak_stored',
                'dt' => 0
            ],
            [
                'db' => 'symbol',
                'dt' => 1
            ],
            [
                'db' => 'streak',
                'dt' => 2
            ],
            [
                'db' => 'move_percentage',
                'dt' => 3
            ],
            [
                'db' => 'streak_volume',
                'dt' => 4
            ],
            [
                'db' => 'name',
                'dt' => 5
            ],
            [
                'db' => 'exchange',
                'dt' => 6
            ],
            [
                'db' => 'sector',
                'dt' => 7
            ],
        ];

        $stock_data = $this->datatables->get(Input::all(), $columns);

        return Response::json($stock_data);
    } 

}
