<?php

namespace App\Http\Controllers;

use App\Questionnaire;

class PagesController extends Controller
{
    public function welcome() {
        $questionnaires = Questionnaire::all();

        return view('welcome', compact('questionnaires'));
    }
}
