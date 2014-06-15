<?php

class Summary extends Eloquent {

	protected $guarded = ['id'];

    protected $table = 'summaries';

    public $timestamps = false;
}
