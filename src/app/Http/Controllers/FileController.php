<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index(): View|Factory|Application
    {
        return view("files/index");
    }

    public function allJson(): JsonResponse
    {
        $files = Picture::all();
        return response()->json($files, 200, [], JSON_PRETTY_PRINT);
    }

    public function show(Request $request): JsonResponse
    {
        $messages = [
            'id.required' => 'ID обязателен для заполнения',
            'id.numeric' => 'ID должен быть числом',
        ];

        $validatedData = $request->validate([
            'id' => 'required|numeric',
        ], $messages);

        $id = $request->input('id');
        $file = Picture::find($id);
        if (!$file) {
            return response()->json(['message' => 'Файл не найден'], 404, [], JSON_PRETTY_PRINT);
        }
        return response()->json($file, 200, [], JSON_PRETTY_PRINT);
    }
}
