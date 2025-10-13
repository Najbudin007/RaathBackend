<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController
{
    public function index()
    {
        return view('admin.pages.medias.index');
    }
    public function getFolders($folder = '')
    {
        $directories = Storage::directories($folder);
        return response()->json(['folders' => $directories]);
    }

    public function getFiles($folder = '')
    {
        $files = Storage::files($folder);
        $images = [];
        $documents = [];
        $fileIcons = [
            'pdf' => 'https://cdn-icons-png.flaticon.com/512/337/337946.png',
            'doc' => 'https://cdn-icons-png.flaticon.com/512/337/337946.png',
            'docx' => 'https://cdn-icons-png.flaticon.com/512/337/337946.png',
        ];
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp','webp'];

        foreach ($files as $file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array($extension, $imageExtensions)) {
                $images[] = [
                    'path' => Str::storage_path($file),
                    'name' => $file
                    
                ];
            } else {
                $documents[] = [
                    'path' => Str::storage_path($file),
                    'name' => $file,
                    'icon' => $fileIcons[$extension] ?? 'https://cdn-icons-png.flaticon.com/512/337/337946.png', // default file icon
                ];
            }
        }

        return response()->json(['images' => $images, 'documents' => $documents]);
    }

    public function createFolder(Request $request)
    {
        $folderName = $request->input('folderName');
        if (Storage::exists($folderName)) {
            return response()->json(['message' => 'Folder already exists'], 409);
        }
        Storage::makeDirectory($folderName);
        return response()->json(['message' => 'Folder created successfully']);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'mimes:jpg,bmp,png,webp,pdf'
        ]);
        $file = $request->file('file');
        $folderName = $request->input('folderName');
        $path = $file->store($folderName);
        return response()->json(['message' => 'Image uploaded successfully', 'path' => $path]);
    }

    public function deleteImage(Request $request)
    {
        $image = $request->input('image');
        Storage::delete($image);
        return response()->json(['message' => 'Image deleted successfully']);
    }

    public function deleteFolder(Request $request)
    {
        $folderName = $request->input('folderName');
        Storage::deleteDirectory($folderName);
        return response()->json(['message' => 'Folder deleted successfully']);
    }

    public function deleteDocument(Request $request)
    {
        $document = $request->input('document');
        Storage::delete($document);
        return response()->json(['message' => 'Document deleted successfully']);
    }
}
