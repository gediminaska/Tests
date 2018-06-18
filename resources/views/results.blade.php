@extends('layouts.main')
@section('content')
    <h1 class="text-center">Your results</h1>
    @foreach($answers as $answer)
        <h3>{{ $answer->question->body }}</h3>
        @foreach($answer->question->options as $option)
            <div class="form-check">
                <input class="form-check-input"
                       type="radio" id={{ $option->id }}
                        disabled
                        {{ in_array($option->id, $answers->pluck('option_id')->toArray()) ? 'checked' : ''}}
                >
                <label class="form-check-label {{ $option->correct? 'text-success': '' }}" for={{ $option->id }}>
                    {{ $option->text }}
                    <strong>{{ $option->correct && in_array($option->id, $answers->pluck('option_id')->toArray()) ? '+' . $answer->question->points : ''}}</strong>
                </label>
            </div>
        @endforeach
    @endforeach
    <a href="{{ route('attempt.finished', $attempt->token) }}">
        <button class="btn btn-primary btn-block">Back</button>
    </a>
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
