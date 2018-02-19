@extends('layouts.app')

@section('content')
    <h1 class="text-center">Devices</h1>
    @if (count($devices) > 0)
        @foreach ($devices as $device)   
            <div class="card card-body bg-light mb-3">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        {{--  <img src="/storage/cover_images/{{$device->cover_image}}" alt="cover image" style="width: 100%">  --}}
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3>{{$device->name}}</h3>
                        {{--  <small>Assigned to {{$post->user->name}}</small>  --}}
                    </div>
                </div>                   
            </div>
        @endforeach
        <div class="paginationDiv">{{$devices->links()}}</div> 
    @else   
        <p>No devices found</p>
    @endif
@endsection