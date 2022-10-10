<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PhotoService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class PhotoController extends Controller
{
    public function upload(Request $request, PhotoService $service): array
    {
        /** @var array<UploadedFile> $photos */
        $photos = $request->file('photos') ?: [];

        @ini_set('memory_limit', '1G');

        $array = [];
        /** @var UploadedFile $item */
        foreach ($photos as $item) {
            try {
                $array[] = $service->store($item);
            } catch (\Throwable $e) {
                Log::error('上传图片时发生异常', [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'message' => $e->getMessage(),
                    'filename' => $item->getClientOriginalName(),
                    'filesize' => $item->getSize() / 1024,
                    'trace' => $e->getTraceAsString(),
                ]);
                continue;
            }
        }

        return $array;
    }

    public function destroy(Request $request, PhotoService $service)
    {
        $service->destroy([$request->post('id')]);
    }
}
