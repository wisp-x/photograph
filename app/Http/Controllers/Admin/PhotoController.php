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
        /** @var UploadedFile $photo */
        $photo = $request->file('photo');

        @ini_set('memory_limit', '1G');

        try {
            $array = $service->store($photo);
        } catch (\Throwable $e) {
            Log::error('上传图片时发生异常', [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'message' => $e->getMessage(),
                'filename' => $photo->getClientOriginalName(),
                'filesize' => $photo->getSize() / 1024,
                'trace' => $e->getTraceAsString(),
            ]);
            abort(422, $e->getMessage());
        }

        return $array;
    }

    public function destroy(Request $request, PhotoService $service): void
    {
        $service->destroy([$request->post('id')]);
    }
}
