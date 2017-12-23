
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @foreach($notifications as $not)
                <div class="avatar">
                    <a href="{{ url($not['data']['user']['slug']) }}">
                        <img src="{{ $not['data']['user']['avatar'] }}" width="48" class="img-circle">
                    </a>                    
                </div>
                <div class="message-notis">
                    <a href="{{ url($not['data']['user']['slug']) }}">{{ $not['data']['user']['name'] }}</a>
                    <span>{{ $not['data']['message'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
