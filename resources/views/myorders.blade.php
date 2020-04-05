@extends('layouts.app')
@section('content')
    <div class="container">
        <a href={{ URL::previous() }} class="btn btn-primary" style="margin-bottom: 10px;">< Back</a>
        <div class="jumbotron">
            <h1>My Orders</h1>
        </div>
        @if($myorders)
        <table class="table-striped" id="tblmyorders">
            <thead>
                <th>Image</th>
                <th>Item</th>
                <th>Quatity</th>
                <th>Amount Due</th>
            </thead>
            <tbody>
                @foreach ($myorders as $myorder)
                    <tr>
                        <td><img src={{$myorder->order_image}}></td>
                        <td>{{$myorder->order_item}}</td>
                        <td>{{$myorder->order_qty}}</td>
                        <td>PHP {{$myorder->order_cost}}</td>
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
            $("#tblmyorders").DataTable();
        })
    </script>
@endsection