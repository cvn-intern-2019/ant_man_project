<?php

namespace App\Http\Controllers;
use App\Answer;
use Illuminate\Http\Request;
use App\Question;
use Illuminate\Support\Facades\Auth;
use File;

class AnswerController extends Controller
{

	public function store(Request $request)
	{
		$answer = new Answer();
		$answer->content = $request->get('content');
		$answer->user_id = session('id');
		$answer->question_id = $request->get('question_id');
		$id_question=$answer->question_id;
        $question = Question::find($id_question);
        $question->total_answer+=1;
		$question->save();
		$answer->attachment_path = null;
		if($request->hasFile('attachment')) {
			$answer->attachment_path = $request->attachment->getClientOriginalName();
			$request->attachment->move('files\\', $request->attachment->getClientOriginalName());
		}
		$answer->save();
		return redirect()->route('view-topic', ['id' => $answer->question_id]);
	}

	public function edit($id)
	{
		if(Auth::check()){
			$answer = Answer::find($id);
			if(empty($answer)) {
				return redirect()->route('home-page');
			} else{
				$question = Question::where('_id', '=',$answer->question_id)->get();
				return view('editanswer',compact('answer','id','question'));
			}
		} else {
			return view('signin');
		}
	}

	public function update(Request $request, $id)
	{
		$answer = Answer::find($id);
		$answer->content = $request->get('content');
		$answer->attachment_path = null;
		if($request->hasFile('attachment')) {
			File::delete('files\\'.$answer->attachment_path);
			$answer->attachment_path = $request->attachment->getClientOriginalName();
			$request->attachment->move('files\\', $request->attachment->getClientOriginalName());
		}
		$answer->save();
		return redirect()->route('view-topic', ['id' => $answer->question_id]);
	}
}
