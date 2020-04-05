@extends('layouts.app')
@section('content')
    <div class="container">
        <a href={{ URL::previous() }} class="btn btn-success" style="margin-bottom: 10px;">< Back</a>
        <div class="jumbotron">
            <h1>Orders</h1>
        </div>
        @if($orders)
            <table class="table-stiped" id="allorders">
                <thead>
                    <th>Image</th>
                    <th>Item</th>
                    <th>Quatity</th>
                    <th>Amount Due</th>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td><img src={{$order->order_image}}></td>
                            <td>{{$order->order_item}}</td>
                            <td>{{$order->order_qty}}</td>
                            <td>PHP {{$order->order_cost}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $("#allorders").DataTable();
        })
    </script>
@endsection