<!-- resources/views/jwttoken/create.blade.php -->

@extends('jwttoken.layout')

@section('content')
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>Generate JWT Token</h3>
            </div>
        </div>
    </div>
    @if ($errors ?? '' && $errors->any())
        <div class="alert alert-danger">
            Error.<br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('jwttoken.authenticate') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong style="width: 120px;display: inline-block;">Email Address:</strong>
                    <input type="text" name="email" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 10px;">
                <div class="form-group">
                    <strong style="width: 120px;display: inline-block;">Password:</strong>
                    <input type="password" name="password" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="margin-top: 10px;">
                <button type="submit" class="btn btn-success">Generate</button>
            </div>
        </div>
    </form>
    @if ($token ?? '')
        <div class="alert alert-danger" style="margin-top: 30px;">
            JWT Token:<br><textarea readonly="readonly" style="margin: 0px;height: 150px;width: 80%;padding: 10px;">Bearer {{ $token }}</textarea>
        </div>
    @endif
@endsection