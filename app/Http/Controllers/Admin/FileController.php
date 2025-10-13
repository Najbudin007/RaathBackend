<?php

namespace App\Http\Controllers\Admin;

use App\Filepath;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:jpg,jpeg,gif,png,svg', 'max:10000']
        ]);

        if ($request->hasFile('file')) {
           $path = $request->file('file')->store(Filepath::CKEDITOR);
        }
        
        return response()->json(['message' => 'Succes','url' => Str::storage_path($path)], 201);
    }
}
