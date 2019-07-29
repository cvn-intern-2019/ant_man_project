<?php

namespace App\Http\Controllers;
use App\Question;
use Illuminate\Http\Request;
use App\Category;
use App\Attachment;
use Illuminate\Support\Facades\Auth;


class QuestionController extends Controller
{
	public function create()
	{
		if(Auth::check()){
			$categories = Category::all();
			return view('addtopic',compact('categories'));
		} else {
			return view('signin');
		}
	}

	public function store(Request $request)
	{
		$question = new Question();
		$question->title = $request->get('title');
		$question->content = $request->get('content');
		$question->user_id = session('id');
		$question->category_id = $request->get('category');
		$question->total_like = 0;
		$question->total_dislike = 0;
		$question->total_answer = 0;
		$question->save();
		return redirect('/');
	}

	public function edit($id)
	{
		if(Auth::check()){
			$categories = Category::all();
			$question = Question::find($id);
			return view('edittopic',compact('question','id','categories'));
		} else {
			return view('signin');
		}
	}

	public function update(Request $request, $id)
	{
		$question = Question::find($id);
		$question->title = $request->get('title');
		$question->content = $request->get('content');
		$question->category_id = $request->get('category');
		$question->save();
		return redirect()->route('view-topic', ['id' => $id]);
	}

	public function destroy(Request $request)
	{
		$question = Question::find($request->id);
		$question->delete();
		return redirect('/');
	}
}