@extends('layout.master')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.3/css/fileinput.min.css" media="all"
        rel="stylesheet" type="text/css" />
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.3/js/fileinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.3/themes/fa/theme.min.js"></script>
<script>
    $('#fuMain').fileinput({
        theme: 'fa',
        //allowedFileExtensions: ['png', 'jpg'],
        //uploadUrl: '/upload_article_poster',
        uploadAsync: false,
        showUpload: false,
        maxFileSize: 5120,
        removeClass: 'btn btn-warning'
    });

    var simplemde = new SimpleMDE({
        element: document.getElementById("MyID")
    });

</script>

@endsection
@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="row px-3 pt-3">
            <div class="col-sm-1"><img src="{{asset('img/avatar')}}/{{$question->user->avatar}}"
                    class="test rounded-circle align-middle"></div>
            <div class="col-sm-11">
                <div class="font-weight-bold" style="color:#787878; font-size: 25px">{{$question->user->fullname}}

                    <!-- <i class="float-right fa fa-trash" aria-hidden="true" style="margin-right:10px; font-size: 120%; "></i>    -->
                    <!-- Button HTML (to Trigger Modal) -->
                    @if($question->user_id==Session::get('id'))
                    <a href="#myModal" data-toggle="modal"><i class="float-right fa fa-trash" aria-hidden="true"
                            style="margin-right:10px; font-size: 120%; "></i></a>

                    <!-- Modal HTML -->
                    <div id="myModal" class="modal fade" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this topic?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <form action="{{route('delete-topic')}}" method="post">
                                        @csrf
                                        <input type="text" name="id" value="{{$question->id}}" hidden>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{asset('edittopic')}}/{{ $question->id }}"><i class="float-right fa fa-pencil-square-o"
                            aria-hidden="true" style="margin-right:10px; font-size:120%"></i></a>
                    @else
                    @endif

                </div>
                <div>
                    <small class="text-muted" style="color:#5488c7;">
                        <i class="fa fa-calendar" aria-hidden="true"> </i> {{$question->created_at}}
                    </small>
                </div>
                <br>
            </div>
            <div class="col-sm-12 d-flex justify-content-sm-between">
                <h3>{{$question->title}}</h3>
                <span class="badge badge-info" style="height: 20px">{{$question->category->name}}</span>
            </div>
            <div class="col-sm-12">
                <p>{{$question->content}}</p>
                <div class="row" style="width: 300px; color:#787878; font-size: 20px; margin-bottom: 10px">
                    <div class="col-sm">
                        @if (Auth::check())
                        <a href="{{asset('like')}}/{{$question->_id}}/Question/{{Session::get('id')}}"><i
                                class="fa fa-thumbs-up"></i></a> {{$question->total_like}}
                        @else
                        <a href="{{route('sign-in')}}"><i class="fa fa-thumbs-up"></i></a>{{$question->total_like}}
                        @endif
                    </div>
                    <div class="col-sm">
                        <a href="{{asset('dislike')}}/{{$question->_id}}/Question/{{Session::get('id')}}"><i
                                class="fa fa-thumbs-down"></i></a>
                        {{$question->total_dislike}}
                    </div>
                    <div class="col-sm">
                        <i class="fa fa-reply"></i>
                        {{$question->total_answer}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (Auth::check())
    <div class="card shadow" style="margin-top: 20px;">
        <div class="card-body">
            <form enctype="multipart/form-data">
				<div class="row">
					<div class="col-sm-4">
						<div class="file-loading">
							<input id="fuMain" name="avatar" type="file">
						</div>
					</div>
					<div class="col-sm-8">
						<textarea id="MyID"></textarea>
					</div>
				</div>
                <button type="button" class="btn btn-primary float-right">Answer</button>
            </form>
        </div>
    </div>
    @endif

    <div class="card shadow" style="margin-top: 20px; margin-bottom: 20px; ">
        <div class="card-header">
            <h3>Answer</h3>
        </div>
        <!-- ---------------------------------------------------------------------------------------------------------------------------------------- -->
        @if ($best_answer!=null)
        <div class="row px-3 pt-3">

            <div class="col-sm-1">
                <img src="{{asset('img/avatar')}}/{{$best_answer->user->avatar}}"
                    class="test rounded-circle align-middle">
                <br>
                <br>

                <div class="d-flex" style="justify-content :center; align-items:center;  font-size:200%; color:#66ad1f">
                    <i class="fa fa-check" aria-hidden="true"></i>
                </div>


            </div>
            <div class="col-sm-11">
                <div class="font-weight-bold" style="color:#787878; font-size: 20px">{{$best_answer->user->fullname}}
                    @if($best_answer->user_id==Session::get('id'))
                    <a href="{{asset('editanswer')}}/{{ $best_answer->id }}"><i
                            class="float-right fa fa-pencil-square-o" aria-hidden="true"
                            style="margin-right:10px; font-size:120%"></i></a>@else
                    @endif
                </div>

                <div>
                    <small class="text-muted" style="color:#5488c7;">
                        <i class="fa fa-calendar" aria-hidden="true"> </i> {{$best_answer->created_at}}
                    </small>
                </div>
                <br>
                <p>{{$best_answer->content}}</p>
                <div class="row" style=" color:#787878; font-size: 20px ; margin-bottom: 10px">
                    <div class="col-sm-1">
                        <a href="{{asset('like')}}/{{$best_answer->_id}}/Answer/{{Session::get('id')}}"><i
                                class="fa fa-thumbs-up"></i></a>
                        {{$best_answer->total_like}}
                    </div>
                    <div class="col-sm-1">
                        <a href="{{asset('dislike')}}/{{$best_answer->_id}}/Answer/{{Session::get('id')}}"><i
                                class="fa fa-thumbs-down"></i></a>
                        {{$best_answer->total_dislike}}
                    </div>
                    @if (Session::get('id')==$question->user_id)
                    <div class="col-sm-10 d-flex justify-content-sm-end">
                        <a href="{{asset('bestanswer')}}/{{$best_answer->_id}}"><button type="button"
                                class="float-right btn btn-success">Best Answer</button></a>
                    </div>
                    @else
                    @endif

                </div>
            </div>
        </div>
        <hr>
        @endif



        <!-- //------------------------------------------------------------------------------------------------------------------- -->
        @foreach($answers as $answer)
        @if (($best_answer==null) or (($best_answer!=null)and($answer->_id!=$best_answer->_id)))

        <div class="row px-3 pt-3">

            <div class="col-sm-1">
                <img src="{{asset('img/avatar')}}/{{$answer->user->avatar}}" class="test rounded-circle align-middle">
                <br>
                <br>
                @if ($question->best_answer_id == $answer->_id)
                <div class="d-flex" style="justify-content :center; align-items:center;  font-size:200%; color:#66ad1f">
                    <i class="fa fa-check" aria-hidden="true"></i>
                </div>
                @endif

            </div>
            <div class="col-sm-11">

                <div class="font-weight-bold" style="color:#787878; font-size: 20px">{{$answer->user->fullname}}
                    @if (Session::get('id')==$answer->user_id)
                    <a href="{{asset('editanswer')}}/{{ $answer->id }}"><i class="float-right fa fa-pencil-square-o"
                            aria-hidden="true" style="margin-right:10px; font-size:120%"></i> </a>
                    @endif
                </div>

                <div>
                    <small class="text-muted" style="color:#5488c7;">
                        <i class="fa fa-calendar" aria-hidden="true"> </i> {{$answer->created_at}}
                    </small>
                </div>
                <br>
                <p>{{$answer->content}}</p>
                <div class="row" style=" color:#787878; font-size: 20px ; margin-bottom: 10px">
                    <div class="col-sm-1">
                        <a href="{{asset('like')}}/{{$answer->_id}}/Answer/{{Session::get('id')}}"><i
                                class="fa fa-thumbs-up"></i></a>
                        {{$answer->total_like}}
                    </div>
                    <div class="col-sm-1">
                        <a href="{{asset('dislike')}}/{{$answer->_id}}/Answer/{{Session::get('id')}}"><i
                                class="fa fa-thumbs-down"></i></a>
                        {{$answer->total_dislike}}
                    </div>
                    @if (Session::get('id')==$question->user_id)
                    <div class="col-sm-10 d-flex justify-content-sm-end">
                        <a href="{{asset('bestanswer')}}/{{$answer->_id}}"><button type="button"
                                class="float-right btn btn-success">Best Answer</button></a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <hr>
        @endif
        @endforeach
    </div>

</div>
@endsection
