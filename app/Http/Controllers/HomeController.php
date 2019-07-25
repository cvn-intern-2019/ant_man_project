<?php

namespace App\Http\Controllers;
use App\Question;
use Illuminate\Http\Request;
use App\Notification;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
	public function index()
	{
		$questions = Question::all();
		if(Auth::check()){
			$notifications = Notification::where('user_id','=',session('id'))->get();
			return view('home',compact('questions','notifications'));
		}
		return view('home',compact('questions'));
	}
}