<?php

namespace App\Services;

use App\Models\Photo;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use Intervention\Image\Facades\Image as InterventionImage;

class PhotoService
{
    /**
     * 储存图片
     *
     * @param UploadedFile $file
     * @return array<string, mixed>
     */
    public function store(UploadedFile $file): array
    {
        /**
         * @var Filesystem $photoStorage
         * @var Filesystem $thumbnailStorage
         */
        [$photoStorage, $thumbnailStorage] = $this->getStorages();
        $date = date('Ymd');
        $filename = $file->hashName();
        $image = InterventionImage::make($file)->orientate();

        // 获取 exif 信息
        $exif = [];
        foreach ($image->exif() as $key => $value) {
            if (! mb_check_encoding($value)) {
                continue;
            }

            $exif[$key] = is_array($value) ? $value : trim($value);
        }

        // 移除 exif 信息
        if (strtolower($image->getDriver()->getDriverName()) === 'imagick') {
            /** @var \Imagick $imagick */
            $imagick = $image->getCore();

            $profiles = $imagick->getImageProfiles('icc');
            $imagick->stripImage();
            if(! empty($profiles)) {
                $imagick->profileImage("icc", $profiles['icc']);
            }
        }

        $image->save($file->getRealPath(), config('app.photo_quality'));

        // 保存原图
        $photoPathname = sprintf('%s/%s/%s', config('app.photo_path'), $date, $filename);
        $photoStorage->put($photoPathname, $image->getEncoded());
        // 生成缩略图
        $thumbnail = $this->compress($image);
        $thumbnailPathname = sprintf('%s/%s/%s', config('app.thumbnail_path'), $date, $filename);
        $thumbnailStorage->put($thumbnailPathname, $thumbnail->encode(quality: config('app.thumbnail_quality'))->getEncoded());

        $photo = new Photo([
            'intro' => '',
            'width' => $image->width(),
            'height' => $image->height(),
            'size' => sprintf('%.2f', $file->getSize() / 1024),
            'filename' => $file->getClientOriginalName() ?: '',
            'pathname' => $photoPathname,
            'thumbnail_pathname' => $thumbnailPathname,
            'md5' => md5_file($file->getRealPath()),
            'sha1' => sha1_file($file->getRealPath()),
            'exif' => $exif,
        ]);

        $photo->save();

        $image->destroy();
        $thumbnail->destroy();

        return $photo->append(['url', 'thumbnail_url'])->setVisible([
            'id', 'filename', 'url', 'thumbnail_url',
        ])->toArray();
    }

    /**
     * 删除图片记录以及物理文件(包含缩略图)
     *
     * @param array $keys
     * @return int
     */
    public function destroy(array $keys): int
    {
        $i = 0;

        Photo::query()->whereIn('id', $keys)->cursor()->each(function (Photo $photo) use (&$i) {
            if ($photo->forceDelete()) {
                $i++;
            }
        });

        return $i;
    }

    /**
     * 压缩和等比例缩小图片
     *
     * @param Image $image
     * @return Image
     */
    public function compress(Image $image): Image
    {
        $image = clone $image;
        $width = $w = $image->width();
        $height = $h = $image->height();

        $max = config('app.thumbnail_max_scale');

        if ($w > $max && $h > $max) {
            $scale = min($max / $w, $max / $h);
            $width  = (int)($w * $scale);
            $height = (int)($h * $scale);
        }

        return $image->fit($width, $height, fn($constraint) => $constraint->upsize());
    }

    /**
     * @return array<Filesystem>
     */
    private function getStorages(): array
    {
        return [Storage::disk(config('app.photo_disk')), Storage::disk(config('app.thumbnail_disk'))];
    }
}
