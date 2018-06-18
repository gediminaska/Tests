@extends('layouts.main')
@section('content')
    <div class="form-group">
        <form action="{{ route('attempt.submit', $token) }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <h4>{{ $question->body }} <strong>({{ $question->points }} points)</strong></h4>
                @foreach($question->options as $option)
                    <div class="form-check">
                        <input class="form-check-input" onclick="enableSubmitButton()" type="radio" name="option_id"
                               id={{ $option->id }} value={{ $option->id }} required>
                        <label class="form-check-label" for={{ $option->id }}>
                            {{ $option->text }}
                        </label>
                    </div>
                @endforeach
                <button class="btn btn-primary btn-block btn-lg" type="submit" id="submitButton" disabled>Submit
                    answer
                </button>
            </div>
        </form>
    </div>
@stop

@section('panel-right')
    <h3>You have answered
        <strong>{{ count($attempt->answers)  }}</strong>/{{ count($attempt->questionnaire->questions) }} questions</h3>
    <h3>Your current score: <strong>{{ $attempt->score  }}</strong> points</h3>
    <form action="{{ route('attempt.reset', $token) }}" method="POST">
        {{ csrf_field() }}
        <input type="submit" class="btn btn-warning btn-block"
               value="Reset test" {{ count($attempt->answers) == 0 ? 'disabled' : ''}}>
    </form>
    <a href="{{ route('welcome') }}">
        <button class="btn btn-secondary btn-block">Leave test</button>
    </a>
@stop

<script>
    function enableSubmitButton() {
        return document.getElementById("submitButton").disabled = false;
    }
</script>