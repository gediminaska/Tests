<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Attempt;
use App\Option;
use App\Question;
use Illuminate\Http\Request;

class AttemptsController extends Controller
{

    /**
     * @param $questionnaire_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function begin($questionnaire_id)
    {
        $token = str_random(15);
        $attempt = new Attempt;
        $attempt->questionnaire_id = $questionnaire_id;
        $attempt->token = $token;
        $attempt->save();
        return redirect()->route('attempt.show', $token);
    }

    /**
     * @param $token
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function submit($token, Request $request)
    {
        $attempt = Attempt::query()->where('token', $token)->first();
        $selectedOption = Option::query()->where('id', $request->option_id)->first();

        $this->saveAnswer($request, $attempt, $selectedOption);
        $this->updateScore($selectedOption, $attempt);

        $unansweredQuestions = $this->findUnanswered($attempt);

        if (count($unansweredQuestions) == 0) {
            $attempt->save();
            return redirect()->route('attempt.finished', $token);
        } else {
            $this->changeCurrentQuestion($unansweredQuestions, $attempt);
            $attempt->save();
            return redirect()->route('attempt.show', $token);
        }
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finished($token) {
        $attempt = Attempt::query()->where('token', $token)->first();
        return view('done', compact('attempt'));
    }
    /**
     * @param Request $request
     * @param $attempt
     * @param $selectedOption
     */
    public function saveAnswer(Request $request, $attempt, $selectedOption): void
    {
        $answer = new Answer;
        $answer->attempt_id = $attempt->id;
        $answer->question_id = $selectedOption->question->id;
        $answer->option_id = $request->option_id;
        $answer->save();
    }

    /**
     * @param $selectedOption
     * @param $attempt
     */
    public function updateScore($selectedOption, $attempt): void
    {
        if ($selectedOption->correct) {
            $attempt->score += $selectedOption->question->points;
        }
    }

    /**
     * @param $attempt
     * @return array
     */
    public function findUnanswered($attempt): array
    {
        $questions = Question::query()->where('questionnaire_id', $attempt->questionnaire_id);
        $answeredQuestions = Answer::query()->where('attempt_id', $attempt->id)->pluck('question_id')->toArray();
        $unansweredQuestions = array_diff($questions->pluck('id')->toArray(), $answeredQuestions);
        return $unansweredQuestions;
    }

    /**
     * @param $unansweredQuestions
     * @param $attempt
     */
    public function changeCurrentQuestion($unansweredQuestions, $attempt): void
    {
        shuffle($unansweredQuestions);
        $question = Question::query()->where('id', $unansweredQuestions[0])->first();
        $attempt->current_question_id = $question->id;
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($token)
    {
        $attempt = Attempt::query()->where('token', $token)->first();
        $question = $this->getNextQuestion($attempt);
        return view('question', compact('question', 'token', 'attempt'));
    }

    /**
     * @param $attempt
     * @return mixed
     */
    public function getNextQuestion($attempt)
    {
        if (!isset($attempt->current_question_id)) {
            $questions = Question::query()->where('questionnaire_id', $attempt->questionnaire_id)->pluck('id')->toArray();
            shuffle($questions);
            $question = Question::query()->where('id', $questions[0])->first();
            $attempt->current_question_id = $questions[0];
            $attempt->save();
        } else {
            $question = Question::query()->where('id', $attempt->current_question_id)->first();
        }
        return $question;
    }

    /**
     * @param $token
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function saveScore($token, Request $request)
    {
        $attempt = Attempt::query()->where('token', $token)->first();
        $attempt->name = $request->name;
        $attempt->save();
        return redirect()->route('welcome');
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function results($token)
    {
        $attempt = Attempt::query()->where('token', $token)->first();
        $answers = Answer::query()->where('attempt_id', $attempt->id)->get();

        if (count($this->findUnanswered($attempt)) == 0) {
            return view('results', compact('attempt', 'answers'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset($token)
    {
        $attempt = Attempt::query()->where('token', $token)->first();
        if (count($attempt->answers) == 0) {
            return redirect()->back();
        };
        foreach ($attempt->answers as $answer) {
            $answer->delete();
        }
        $attempt->current_question_id = null;
        $attempt->score = 0;
        $attempt->save();

        return redirect()->route('attempt.show', $attempt->token);

    }
}
