@extends('layouts.main')
@section('content')
    <h2>You have finished the test!</h2>
    <h4>Your score is <strong>{{ $attempt->score }}</strong> points</h4>
    <h4>Enter you name and your score might end up in top scores.</h4>
    <form action="{{ route('attempt.save', $attempt->token) }}" method="POST">
        {{ csrf_field() }}
        <div class="form-group row">
            <div class="col-sm-6 my-1">
                <input type="text" class="form-control" id="username" name="name" placeholder="Your name" required>
            </div>
            <div class="col-sm-6 my-1">
                <button class="btn btn-primary btn-block" type="sumbit">Save</button>
            </div>
        </div>
    </form>
    <a href="{{ route('attempt.results', $attempt->token) }}">See your results</a>
    <br>
    <br>
    <form action="{{ route('attempt.reset', $attempt->token) }}" method="POST">
        {{ csrf_field() }}
        <input type="submit" class="btn btn-warning btn-block" value="Reset test">
    </form>
    <br>
    <a href="{{ route('welcome') }}">
        <button class="btn btn-secondary btn-block">Home page</button>
    </a>
@stop