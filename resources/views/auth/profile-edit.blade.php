@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <profile-form :uid="{{ $user->user_code }}"></profile-form>
        </div>
    </div>
</div>
@endsection
