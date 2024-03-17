<?php

namespace App\Http\Controllers;

use App\Custom\CustomUnique;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Models\Picture;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class ImageController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $sortBy = request()->query('sortBy', 'name');
        $sortOrder = request()->query('sortOrder', 'asc');
        $images = Picture::orderBy($sortBy, $sortOrder)->paginate(5);

        return view('images/index', compact('images', 'sortBy', 'sortOrder'));
    }

    /**
     * @param Picture $image
     * @param $id
     * @return BinaryFileResponse|void
     */
    public function download(Picture $image, $id)
    {
        $image = $image->find($id);
        if ($image) {
            $zip = new ZipArchive;
            $zipFileName = 'image_' . $image->id . '.zip';
            $zipFilePath = public_path($zipFileName);

            if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
                $filePath = public_path('images/' . $image->name);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $image->name);
                }

                $zip->close();

                return response()->download($zipFilePath);
            }
        }
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function loader()
    {
        return view('images.loader');
    }

    /**
     * @param Request $request
     * @param CustomUnique $unique
     * @return RedirectResponse
     */
    public function store(Request $request, CustomUnique $unique): RedirectResponse
    {
        $messages = [
            'images.*.image' => 'Файл должен быть изображением',
            'images.*.mimes' => 'Допустимые форматы изображений: jpeg, png, jpg, gif',
            'images.*.max' => 'Максимальный размер изображения должен быть 2MB',
            'images.max' => 'Количество изображений не должно превышать 5',
        ];

        $request->validate([
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'max:5',
        ], $messages);

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $imageName = $image->getClientOriginalName();
                $imageName = strtolower($imageName);
                $pathToImages = public_path('images');
                if (file_exists($pathToImages . '/' . $imageName)) {
                    $imageName = $unique($imageName);
                }
                $compressedImage = Image::make($image)->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('jpg', 80);
                $compressedImageName = 'compressed_' . $imageName;
                $compressedImage->save(public_path('compressed_images/' . $compressedImageName));

                $image->move(public_path('images'), $imageName);

                Picture::create([
                    'name' => $imageName,
                    'uploaded_at' => now(),
                ]);

            }

            return back()->with('success', 'Изображения успешно загружены');
        }

        return back()->with('error', 'Не выбраны изображения для загрузки');
    }
}
