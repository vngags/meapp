@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        {{--  <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Product Create</div>

                <div class="panel-body">
                    <form action="{{ route('product.store', ['user_slug' => Auth::user()->slug]) }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>

                        <div class="form-group">
                            <label>Body</label>
                            <textarea name="body" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  --}}
        <product-form></product-form>
    </div>
</div>
@endsection
