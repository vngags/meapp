@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <profile-form :slug=`{{ $user->slug }}`></profile-form>
        </div>
    </div>
</div>
@endsection
