<?php

namespace App\Http\Controllers;

use App\Http\Requests\Media\StoreRequest;
use App\Http\Requests\Media\UpdateRequest;
use Illuminate\Http\Request;
use Optix\Media\MediaUploader;
use Optix\Media\Models\Media;

class FileController extends Controller
{
    public function index()
    {
        return response()->json([
            Media::all()
        ]);
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        $media = MediaUploader::fromFile($validated['file'])
            ->upload();

        return response()->json([
            'message' => 'Файл загружен',
            'media' => $media
        ], 201);
    }

    public function show(Media $file)
    {
        return response()->json([
            'media' => $file
        ]);
    }

    public function update(UpdateRequest $request, Media $file)
    {
        $validated = $request->validated();

        $file->update(
            $validated
        );

        return response()->json([
            'message' => 'Файл обновлён',
            'media' => $file
        ], 201);
    }

    public function destroy(Media $file)
    {
        $file->delete();

        return response()->json([
            'message' => 'Файл был удалён',
            'media' => $file
        ], 201);
    }
}
