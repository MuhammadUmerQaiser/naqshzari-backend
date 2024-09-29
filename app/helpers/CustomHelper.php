<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

function paginate($data)
{
    $collection = collect($data['meta']);
    $data = $collection->put('data', $data['data']);
    return $data;
}

function generateSlug($title){
    $slug = Str::slug($title);
    $random = Str::random(5);
    $uniqueSlug = $slug . '-' . $random;
    return $uniqueSlug;
}

function saveFile(Illuminate\Http\UploadedFile $file, string $subFolder, string $disk = 'local')
{
    $extension = $file->getClientOriginalExtension();
    $fileName = time() . rand(1000, 9999) . '.' . $extension;
    $fileSize = $file->getSize();
    $fileType = $file->getMimeType();

    $sanitizedName = str_replace($extension, '', Illuminate\Support\Str::slug($file->getClientOriginalName()));

    if ($disk == "s3") {
        $path = $subFolder . '/' . $fileName . '.' . $extension;
        \Illuminate\Support\Facades\Storage::disk('s3')->put($path, file_get_contents($file));
    } else {
        if (!File::exists(public_path($subFolder))) {
            File::makeDirectory(public_path($subFolder), 777, true, true);
        }
        $file->move(public_path($subFolder), $fileName);
        $path = "{$subFolder}/{$fileName}";
    }

    return [
        "name" => $fileName,
        "extension" => $extension,
        "fileSize" => $fileSize,
        "fileType" => $fileType,
        "path" => $path,
        "disk" => $disk
    ];
}
