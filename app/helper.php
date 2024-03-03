<?php

use Illuminate\Http\Request;

if (!function_exists("uploadImage")) {
    function uploadImage(Request $request, string $setImageName, string $filename = "image", string $folderName = "profiles")
    {
        $imageFile = $request->file($filename);
        $imageName = $setImageName . uniqid("-") . "." . $imageFile->getClientOriginalExtension();
        $imagePath = "public/{$folderName}/" . $imageName;
        $imageFile->storeAs($imagePath . "/");
        return $imageName;
    }
}
