<?php

namespace App\Http\Controllers;
use App\Answer;
use Illuminate\Http\Request;
use App\Question;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
	public function edit($id)
	{
		if(Auth::check()){
			$answer = Answer::find($id);
			$question = Question::where('_id', '=',$answer->question_id)->get();
			return view('editanswer',compact('answer','id','question'));
		} else {
			return view('signin');
		}
	}

	public function update(Request $request, $id)
	{
		$answer = Answer::find($id);
		$answer->content = $request->get('content');
		$answer->save();
		return redirect()->route('view-topic', ['id' => $answer->question_id]);
	}
}