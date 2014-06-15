@extends('layouts.master')

@section('content')

    <h2>Consecutive Positive/Negative Closing Price Streaks</h2>
    <table class="table table-bordered datatables">
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Streak</th>
                <th>Name</th>
                <th>Exchange</th>
                <th>Sector</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th>Symbol</th>
                <th>Streak</th>
                <th>Name</th>
                <th>Exchange</th>
                <th>Sector</th>
            </tr>
        </tfoot>

    </table>

@stop