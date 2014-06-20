@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12 pt10">
            <a href="//www.bluehost.com/track/economical/" target="_blank">
                <img class="center-block" border="0" src="//bluehost-cdn.com/media/partner/images/economical/760x80/bh-760x80-02-dy.png">
            </a>
        </div>
    </div>
    
    <h2>{{ $header }}</h2><br>
    <table class="table table-bordered table-striped datatables">
        <thead>
            <tr>
                <th>Close</th>
                <th>Symbol</th>
                <th>Streak</th>
                <th>Move %</th>
                <th>Streak Volume</th>
                <th>Name</th>
                <th>Exchange</th>
                <th>Sector</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th>Close</th>
                <th>Symbol</th>
                <th>Streak</th>
                <th>Move %</th>
                <th>Streak Volume</th>
                <th>Name</th>
                <th>Exchange</th>
                <th>Sector</th>
            </tr>
        </tfoot>
    </table>

@stop