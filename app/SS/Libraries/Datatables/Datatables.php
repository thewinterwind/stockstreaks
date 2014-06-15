<?php namespace SS\Libraries\Datatables;
 
/*
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 */
 
class Datatables {
    protected $table;

    public function __construct($table = 'stocks', $pk = 'id')
    {
        $this->table = $table;
        $this->primaryKey = $pk;
    }

    public function get($request, $columns)
    { 
        return SSP::simple($request, $this->table, $this->primaryKey, $columns);
    }
}