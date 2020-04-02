@extends('layouts.app')
@section('content')
<div class="container">
    @foreach ($orders as $order)
       <h1> {{$order}}</h1>
    @endforeach
</div>
@endsection
@section('scripts')
@endsection