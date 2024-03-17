<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Загрузка изображений</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css"
          rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 style="margin-top: 30px;">Загрузка изображений</h2>
    <div class="panel-body">
        <div class="col-md-8">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>

                @if (Session::has('images') && is_array(Session::get('images')))
                    @foreach (Session::get('images') as $image)
                        <img src="{{ asset('images') }}/{{ $image }}" width="300" height="300" alt="">
                    @endforeach
                @endif
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Ошибка</strong> У нас проблемы
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{route('images.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row"><br>
                    <div class="col-md-6">
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success">Загрузить</button>
                    </div>
                </div>
            </form>
            <div style="margin-bottom: 20px;">

            </div>
            <div>
                <a href="{{ route('images.index') }}" class="btn btn-primary">На главную</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
