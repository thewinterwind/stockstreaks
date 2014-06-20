@extends('layouts.master')

@section('content')

    <h2>{{ $header }}</h2><br>
    <table class="table table-bordered table-striped datatables">
        <thead>
            <tr>
                <th>Close</th>
                <th>Symbol</th>
                <th>Streak</th>
                <th>Move %</th>
                <th>Volume</th>
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
                <th>Volume</th>
                <th>Name</th>
                <th>Exchange</th>
                <th>Sector</th>
            </tr>
        </tfoot>
    </table>

@stop