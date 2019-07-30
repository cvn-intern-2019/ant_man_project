<?php

namespace App\Http\Controllers;
use App\Question;
use Illuminate\Http\Request;
use App\Category;
use App\Answer;
use Illuminate\Support\Facades\Auth;
use File;


class QuestionController extends Controller
{
	public function create()
	{
		$categories = Category::all();

		return view('add_topic',compact('categories'));
	}

	public function store(Request $request)
	{
		// $validatedData = $request->validate([
		// 	'title' => 'required|max:255',
		// 	'content' => 'required',
		// ]);

		$question = new Question();
		$question->title = $request->get('title');
		$question->content = $request->get('content');
		$question->user_id = Auth::user()->_id;
		$question->category_id = $request->get('category');
		$question->total_like = 0;
		$question->total_dislike = 0;
		$question->total_answer = 0;
		$question->attachment_path = null;
		$question->save();
		if($request->hasFile('attachment')) {
			$filename = $question->_id.$request->attachment->getClientOriginalName();
			$question->attachment_path = $filename;
			$request->attachment->move('files\\', $filename);
		}
		$question->save();

		return redirect('/');
	}

	public function edit($id)
	{
		if(!Auth::check()){

			return view('signin');
		}

		$categories = Category::all();
		$question = Question::find($id);
		if(empty($question)){

			return redirect()->route('home-page');
		} 

		return view('edit_topic',compact('question','id','categories'));
	}
	
	public function update(Request $request)
	{
		// $validatedData = $request->validate([
		// 	'id' => 'required',
		// 	'title' => 'required|max:255',
		// 	'content' => 'required',
		// 	'category' => 'required',
		// ]);

		$question = Question::find($request->get('id'));
		$question->title = $request->get('title');
		$question->content = $request->get('content');
		$question->category_id = $request->get('category');
		if($request->hasFile('attachment')) {
			File::delete('files\\'.$question->attachment_path);
			$filename = $question->_id.$request->attachment->getClientOriginalName();
			$question->attachment_path = $filename;
			$request->attachment->move('files\\', $filename);
		}
		$question->save();

		return redirect()->route('view-topic', ['id' => $request->get('id')]);
	}

	public function destroy(Request $request)
	{


		$this->removeQuestion($request);

		return redirect('/');
	}

	public function removeQuestion(Request $request)
	{
		
		$question = Question::where('user_id', '=', session('id'))->where('_id', '=', $request->_id)->first();
        if(empty($question)) return 'Question not found';
        else{
            $answers = Answer::where('question_id','=',$question->_id)->get();
            foreach($answers as $answer){
                if(!empty($answer->attachment_path)) File::delete('files\\'.$answer->attachment_path);
                $answer->delete();
            }
            //$answers->delete();
            if(!empty($question->attachment_path)) File::delete('files\\'.$question->attachment_path);
            $question->delete();
        }
		return redirect()->back();
	}

	public function test()
	{
		File::delete("files\ask.ico");
		return "?";
	}

		
	}

}