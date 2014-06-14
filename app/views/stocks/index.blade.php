@extends('layouts.master')

@section('content')

    <h2>Consecutive Positive/Negative Closing Price Streaks</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Streak</th>
                <th>Name</th>
                <th>Streak Move %</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>MSFT</td>
                <td class="positive">+3 days</td>
                <td>Microsoft</td>
                <td class="positive">+17%</td>
            </tr>
            <tr>
                <td>YHOO</td>
                <td class="negative">-4 days</td>
                <td>Yahoo!</td>
                <td class="negative">-27%</td>
            </tr>
        </tbody>
    </table>

@stop