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
                'db' => 'name',
                'dt' => 2
            ],
            [
                'db' => 'exchange',
                'dt' => 3
            ],
            [
                'db' => 'sector',
                'dt' => 4
            ],
        ];

        return $this->datatables->get(Input::all(), $columns);
    } 

}
