<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Answer;
use App\User;
use File;

class ProfileController extends Controller
{
    public function index_manage_question()
	{
        $questions = Question::where('user_id', '=', session('id'))->get();
        $active_manage_question = true;
		return view('manage_question',compact('questions','active_manage_question'));
    }
    public function index_manage_answer()
	{
        $answers = Answer::where('user_id', '=', session('id'))->get();
        $active_manage_answer = true;
		return view('manage_answer',compact('answers','active_manage_answer'));
    }
    public function remove_question(Request $request)
	{
        $question = Question::where('user_id', '=', session('id'))->where('_id', '=', $request->_id)->first();
        if(empty($question)) return 'Question not found';
        else{
            $answers = Answer::where('question_id','=',$question->_id)->get();
            foreach($answers as $answer){
                if(!empty($answer->path)) File::delete($answer->path);
                $answer->delete();
            }
            //$answers->delete();
            if(!empty($question->path)) File::delete($question->path);
            $question->delete();
        }
        return redirect()->route('manage_question');
    }
    public function change_avatar(Request $request)
    {
		if ($request->hasFile('avatar')) {
            $request->avatar->move('img\avatar\\', session('id').$request->avatar->getClientOriginalName());
            $user = User::find(session('id'));
            $user->avatar=session('id').$request->avatar->getClientOriginalName();
            $user->save();

            Session()->put('avatar','img\avatar\\'.$user->avatar);
        }
        return redirect('profile');
	}
}
