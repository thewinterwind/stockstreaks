@extends('layouts.master')

@section('content')

    <h2>Stockstreaks.com Winning/Losing Closing Price Streaks</h2><br>
    <table class="table table-bordered table-striped datatables">
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Streak</th>
                <th>Move %</th>
                <th>Name</th>
                <th>Exchange</th>
                <th>Sector</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th>Symbol</th>
                <th>Streak</th>
                <th>Move %</th>
                <th>Name</th>
                <th>Exchange</th>
                <th>Sector</th>
            </tr>
        </tfoot>

    </table>

@stop