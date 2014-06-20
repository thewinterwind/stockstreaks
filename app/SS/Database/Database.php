<?php namespace SS\Database;

use DB;

class Database {

    public function remove_whitespace_from_field($table, $field)
    {
        $rows = DB::table($table)->select($field)->get();

        foreach ($rows as $row)
        {
            if ($row->$field !== remove_whitespace($row->$field))
            {
                DB::table($table)
                    ->where($field, remove_whitespace($row->$field))
                    ->update([
                        $field => remove_whitespace($row->$field)
                    ]);

                print "Removed whitespace for: " . $row->$field . PHP_EOL;
            }
        }
    }
}