<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    public function getImage($filename)
    {
        $path = storage_path("app/public/images/{$filename}");

        if (!Storage::exists("public/images/{$filename}")) {
            abort(404);
        }

        $file = Storage::get("public/images/{$filename}");
        $type = Storage::mimeType("public/images/{$filename}");

        return response($file)->header('Content-Type', $type);
    }
    public function getImageProduct($filename)
    {
        $path = storage_path("app/public/images/products/{$filename}");

        if (!Storage::exists("public/images/products/{$filename}")) {
            abort(404);
        }

        $file = Storage::get("public/images/products/{$filename}");
        $type = Storage::mimeType("public/images/products/{$filename}");

        return response($file)->header('Content-Type', $type);
    }
}
