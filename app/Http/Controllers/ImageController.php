<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function convert(Request $request)
    {
        // Validasi file input
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'format' => 'required|in:jpeg,png,jpg,webp',
            'width' => 'required|integer|min:10', // Lebar yang diinginkan
            'height' => 'required|integer|min:10', // Tinggi yang diinginkan
            'jpeg' => 'integer',
            'png' => 'integer',
            'jpg' => 'integer',
            'webp' => 'integer',
            'name' => 'nullable|string'
        ]);

        $file = $request->file('image');
        $format = $request->input('format');
        $width = $request->input('width');
        $height = $request->input('height');
        $jpeg = $request->input('jpeg');
        $png = $request->input('png');
        $jpg = $request->input('jpg');
        $webp = $request->input('webp');
        $name = trim($request->input('name'));

        // Dapatkan path sementara
        $tempPath = $file->getPathname();

        if (empty($name)) {
            $newFilename = time() . '.' . $format;
        } else {
            $newFilename = $name . '.' . $format;
        }

        // Load gambar menggunakan GD Library
        if ($file->getClientOriginalExtension() === 'webp') {
            $image = imagecreatefromwebp($tempPath);
        } elseif ($file->getClientOriginalExtension() === 'jpg') {
            $image = imagecreatefromjpeg($tempPath);
        } elseif ($file->getClientOriginalExtension() === 'jpeg') {
            $image = imagecreatefromjpeg($tempPath);
        } else {
            $image = imagecreatefromstring(file_get_contents($tempPath));
        }


        // Resize gambar ke resolusi yang diinginkan
        $resizedImage = imagescale($image, $width, $height);

        // Tentukan format output dan kompresi
        $outputPath = public_path('converted/' . $newFilename);

        if ($format === 'jpeg') {
            // Kompresi JPEG (50 = kualitas rendah)
            imagejpeg($resizedImage, $outputPath, $jpeg);
        } elseif ($format === 'png') {
            // Kompresi PNG (9 = kompresi tertinggi)
            imagepng($resizedImage, $outputPath, $png);
        } elseif ($format === 'webp') {
            // Kompresi WebP
            imagewebp($resizedImage, $outputPath, $webp);
        } else if ($format === 'jpg') {
            imagewebp($resizedImage, $outputPath, $jpg);
        }

        $fileSize = filesize($outputPath);
        $resizedWidth = imagesx($resizedImage);
        $resizedHeight = imagesy($resizedImage);
        // Bersihkan memori
        imagedestroy($image);
        imagedestroy($resizedImage);

        // Return URL gambar hasil konversi
        return response()->json([
            'message' => 'Image converted successfully',
            'url' => asset('converted/' . $newFilename),
            'fileName' => $newFilename,
            'fileSize' => round($fileSize / 1024, 2),
            'width' => $resizedWidth,
            'height' => $resizedHeight,
        ]);
    }
}
