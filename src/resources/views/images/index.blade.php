<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<header style="background-color: #333; color: #fff; padding: 10px;">
    <div style="margin-top: 10px;">
        <a href="{{route('images.loader')}}" class="btn btn-primary" style="margin-right: 10px;">Загрузить фото</a>
        <a href="{{ route('files.index') }}" class="btn btn-primary">Посмотреть JSON</a>
    </div>
</header>
<h1 class="page-title" style="color: #333; font-family: Arial, sans-serif;">Загруженные изображения</h1>
<th style="background-color: #f2f2f2; color: #333; text-align: center;">
    <a href="{{ request()->fullUrlWithQuery(['sortBy' => 'name', 'sortOrder' => ($sortBy == 'name' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}"
       class="btn btn-primary">
        Название
    </a>
</th>
<th style="background-color: #f2f2f2; color: #333; text-align: center;">
    <a href="{{ request()->fullUrlWithQuery(['sortBy' => 'created_at', 'sortOrder' => ($sortBy == 'created_at' && $sortOrder == 'asc') ? 'desc' : 'asc']) }}"
       class="btn btn-primary">
        Дата и время загрузки
    </a>
</th>
<table id="imagesTable" class="table table-bordered" style="width: 100%; border-collapse: collapse;">
    <thead>
    <tr>
        <th class="table-header">Название</th>
        <th class="table-header">Дата и время загрузки</th>
        <th class="table-header">Превью</th>
        <th class="table-header">Скачать</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($images as $image)
        <tr>
            <td>{{ $image->name }}</td>
            <td>{{ $image->created_at->format('d.m.Y H:i') }}</td>
            <td>
                <a href="{{ asset('images/' . $image->name) }}" target="_blank">
                    <img src="{{ asset('compressed_images/' .('compressed_'.$image->name)) }}" width="100" alt=""
                         style="border: 1px solid #333;">
                </a>
            </td>
            <td>
                <a href="{{ route('index.download',$image->id)}}" class="download-link">
                    Скачать
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@if ($images->count() > 1)
    <div class="pagination">
        {{ $images->appends(['sortBy' => $sortBy, 'sortOrder' => $sortOrder])->links('pagination::bootstrap-4') }}
    </div>
@endif
</html>
