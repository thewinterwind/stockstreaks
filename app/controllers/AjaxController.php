<?php

use SS\Libraries\Datatables\Datatables;

class AjaxController extends BaseController {

    public function __construct(Datatables $datatables)
    {
        $this->datatables = $datatables;
    }

	public function stock_data()
	{
        $columns = [
            [
                'db' => 'symbol',
                'dt' => 0
            ],
            [
                'db' => 'streak',
                'dt' => 1
            ],
            [
                'db' => 'move_percentage',
                'dt' => 2
            ],
            [
                'db' => 'name',
                'dt' => 3
            ],
            [
                'db' => 'exchange',
                'dt' => 4
            ],
            [
                'db' => 'sector',
                'dt' => 5
            ],
        ];

        $stock_data = $this->datatables->get(Input::all(), $columns);

        return Response::json($stock_data);
    } 

}
