@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <profile :uid="{{ $user->user_code }}"></profile>
        </div>
    </div>
</div>
@endsection
