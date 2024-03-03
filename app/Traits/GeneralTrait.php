<?php

namespace App\Traits;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Image;

trait GeneralTrait
{
    public function uploadImage(Request $request, string $setImageName, string $filename = "image", string $folderName = "profiles")
    {
        $imageFile = $request->file($filename);
        $imageName = $setImageName . uniqid("-") . "." . $imageFile->getClientOriginalExtension();
        $imagePath = "public/{$folderName}/" . $imageName;
        $imageFile->storeAs($imagePath . "/");
        return $imageName;
    }

    public function checkIfUserIsCompany()
    {
        $company = Company::where('user_id', auth()->user()->id)->first();
        if ($company) {
            return true;
        }
        return false;
    }

    public function uploadBase64Image($path, $img, $w = 0, $h = 0)
    {
        try {
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $filename = bin2hex(random_bytes(8)) . '.' . $image_type;

            $image = Image::make($image_base64);
            if ($w != 0 && $h != 0) {
                $image->fit($w, $h);
            }
            $image->stream();
            Storage::disk('local')->put('public/' . $path . $filename, $image->__toString());
            return str_replace(" ", "-", $filename);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return "";
        }
    }

    public function attendanceStatusResolver($status)
    {
        $statusMapping = [
            1 => 'Signed In',
            2 => 'Checked Out',
            3 => 'Checked In',
        ];

        return $statusMapping[$status] ?? 'Signed Out';
    }

    public function attendanceLogClassManager($status)
    {
        $statusMapping = [
            1 => 'bg-success',
            2 => 'bg-warning',
            3 => 'bg-info',
        ];

        return $statusMapping[$status] ?? 'bg-danger';
    }

    public function deleteImageFromStorage($path)
    {
        if (!Storage::exists($path)) {
            Log::warning("Image not found on: " . $path);
            return false; // Indicate failure
        }
        Log::info("Image Deleted: " . $path);
        Storage::delete($path);
        return true; // Indicate success
    }

    /**
     * Upload a PDF file to a specific storage disk.
     *
     * @param UploadedFile $file
     * @param string $disk
     * @param string $path
     * @param string|null $fileName
     * @return string|null
     */
    public function uploadPdf(UploadedFile $file, $disk = 'public', $path = 'pdf', $fileName = null)
    {
        if ($file->isValid() && $file->getClientOriginalExtension() === 'pdf') {
            $fileName = $fileName ?? $file->getClientOriginalName();
            $filePath = $file->storeAs($path, $fileName, $disk);
            return $filePath;
        }
        return null; // Return null if the file is not valid or not a PDF.
    }

}
