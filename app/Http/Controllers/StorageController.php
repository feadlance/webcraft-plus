<?php

namespace App\Http\Controllers;

use File;
use Response;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    public function get($path)
    {
        $path = storage_path("app/public/{$path}");

        if ( File::exists($path) !== true ) {
            return abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header('Content-Type', $type);

        return $response;
    }
}
