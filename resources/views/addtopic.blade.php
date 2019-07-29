<!DOCTYPE html>
<html>

<head>
    <title>Add topic</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    @include('layout.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.3/css/fileinput.min.css" media="all"
        rel="stylesheet" type="text/css" />
</head>

<body
    style="background-image: linear-gradient(60deg, #64b3f4 0%, #c2e59c 100%); background-repeat: no-repeat; background-attachment: fixed;">
    @include('layout.header')
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header">
                <h3>Add new topic</h3>
            </div>
            <div class="card-body">
			<form method="post" action="{{url('addtopic')}}" id="addquestion">
                    @csrf
                    <div class="form-group">
                        <h5>Topic title</h5>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="title" required
                            placeholder="Subject of your topic (limit of 100 characters)" maxlength="100">
                    </div>
                    <div class="form-group">
                        <h5>Category</h5>
                        <select class="form-control col-sm-3" id="exampleFormControlSelect1" name="category">
                            @foreach($categories as $category)
                            <option value="{{$category->_id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="exampleFormControlInput1">
                        <h5>Content</h5>
                    </label>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="file-loading">
                                <input id="fuMain" name="avatar" type="file">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <textarea id="MyID" rows="3" name="content"></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="CheckContent()" class="btn btn-primary float-right">Ask</button>
                </form>

            </div>
        </div>
    </div>
    @include('layout.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.3/js/fileinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.3/themes/fa/theme.min.js"></script>
    <script type="text/javascript">
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

        function CheckContent() {
            if (simplemde.value() != "") {
                document.getElementById("addquestion").submit();
            }
        }
    </script>
</body>

</html>
