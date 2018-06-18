@extends('layouts.main')
@section('content')
    <h1 class="text-center">Tests</h1>
    @foreach($questionnaires as $questionnaire)
        <h5><strong>{{ $questionnaire->title }} </strong>({{ count($questionnaire->questions)}} questions)</h5>
        <p>{{ $questionnaire->description }}. Questions source: <a href="https://www.w3schools.com/quiztest/quiztest.asp?qtest={{ $questionnaire->title }}">Link</a></p>
        <form action="{{ route('attempt.begin', $questionnaire->id) }}" method="POST">
            {{csrf_field()}}
            <button class="btn btn-primary btn-block" type="submit">Begin test</button>
        </form>
    @endforeach
@stop

@section('panel-right')
    <h1 class="text-center">Top 10 scores:</h1>
    @foreach($questionnaires as $questionnaire)
        <h3>{{ $questionnaire->title }} test</h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Score</th>
                <th scope="col">When</th>
            </tr>
            </thead>
            <tbody>
            @foreach($questionnaire->bestAttempts as $key=>$attempt)
                @if($attempt->name)
                    <tr>
                        <th scope="row">{{ $key+1 }}</th>
                        <td>{{$attempt->name}}</td>
                        <td>{{$attempt->score}} points</td>
                        <td>{{ $attempt->updated_at->diffForHumans() }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    @endforeach
@stop



