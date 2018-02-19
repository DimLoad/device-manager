@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="text-center">{{$title}}</h1>
        <div class="row mt-5">
            <div class="col-md-4 pt-1">
                <h2> Team Members </h2>
            </div>
            <div class="col-md-8 pt-1">
                <h2> Devices Allocated </h2>
            </div>
        </div>
    </div>
@endsection