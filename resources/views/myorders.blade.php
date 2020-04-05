@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1>My Orders</h1>
        </div>
        @if ($myorders != NULL)
        <table class="table-stiped" id="tblmyorder">
            <thead>
                <th>Item</th>
                <th>Quatity</th>
                <th>Amount Due</th>
            </thead>
            <tbody>
                @foreach ($myorders as $myorder)
                    <tr>
                        <td>{{$myorder->order_item}}</td>
                        <td>{{$myorder->order_qty}}</td>
                        <td>{{$myorder->order_cost}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
@endsection