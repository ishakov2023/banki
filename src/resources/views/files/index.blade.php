<!DOCTYPE html>
<html lang="en">
<head>
    <title>Информация Json</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<h1>Информация Json</h1>
<div>
    <p>Показать все Json</p>
    <a href="{{ route('files.allJson') }}" class="btn btn-primary">Показать</a>
</div>
<div style="margin-top: 10px;">
    <p>Показать Json по ID</p>
    <form action="{{ route('files.show') }}" method="get">
        @csrf
        <label for="file_id">ID Json</label>
        <input type="number" id="file_id" name="id">
        @error('id')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-primary">Показать</button>
    </form>
</div>
<div style="margin-bottom: 20px;">

</div>
<div>
    <a href="{{ route('images.index') }}" class="btn btn-primary">На главную</a>
</div>
</body>
</html>
