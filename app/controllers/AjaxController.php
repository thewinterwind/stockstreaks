<?php

use SS\Libraries\Datatables\Datatables;

class AjaxController extends Controller {

    public function __construct(Datatables $datatables)
    {
        $this->datatables = $datatables;
    }

	public function stock_data()
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
                'db' => 'move_percentage',
                'dt' => 3
            ],
            [
                'db' => 'name',
                'dt' => 4
            ],
            [
                'db' => 'exchange',
                'dt' => 5
            ],
            [
                'db' => 'sector',
                'dt' => 6
            ],
        ];

        $stock_data = $this->datatables->get(Input::all(), $columns);

        return Response::json($stock_data);
    } 

}
