<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property null|int $album_id
 * @property string $intro
 * @property int $width
 * @property int $height
 * @property float $size
 * @property string $filename
 * @property string $pathname
 * @property string $thumbnail_pathname
 * @property string $url
 * @property string $thumbnail_url
 * @property string $md5
 * @property string $sha1
 * @property int $views
 * @property int $weigh
 * @property Collection $exif
 * @property Collection $data
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property-read null|Album $album
 */
class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id', 'intro', 'width', 'height', 'size',
        'pathname', 'thumbnail_pathname', 'filename', 'md5', 'sha1', 'weigh', 'exif',
    ];

    protected $casts = [
        'exif' => 'collection',
    ];

    protected static function booted()
    {
        static::deleting(function (self $photo) {
            // 删除缩略图
            Storage::disk(config('app.thumbnail_disk'))->delete($photo->thumbnail_pathname);
            // 删除原图
            Storage::disk(config('app.photo_disk'))->delete($photo->pathname);
        });
    }

    public function data(): Attribute
    {
        // 通过 exif 返回规范后的相机、镜头等信息
        return new Attribute(function () {
            $exif = $this->exif;

            if (is_null($exif)) {
                return collect();
            }

            // 计算焦距
            $focalLength = $exif->get('FocalLength');
            if ($focalLength) {
                [$a, $b] = explode('/', $focalLength);
                $focalLength = sprintf('%.1f', $a / $b);
            }

            // 光圈
            $fNumber = $exif->get('FNumber');
            if ($fNumber) {
                [$a, $b] = explode('/', $focalLength);
                $fNumber = sprintf('%.1f', $a / $b);
            } else {
                $fNumber = data_get($exif, 'COMPUTED.ApertureFNumber');
            }

            // 镜头信息
            $lens = '';
            if ($focalLength && $fNumber) {
                $lens = sprintf(
                    '%smm %s %ss ISO %s',
                    $focalLength, // 焦距
                    data_get($exif, 'COMPUTED.ApertureFNumber'), // 光圈
                    $exif->get('ExposureTime'), // 曝光时间
                    $exif->get('PhotographicSensitivity', $exif->get('ISOSpeedRatings')) // 感光度
                );
            }

            return collect([
                'camera' => sprintf('%s %s', $exif->get('Make'), $exif->get('Model')), // 相机信息
                'lens_model' => $exif->get('LensModel', $exif->get('UndefinedTag:0xA434')), // 镜头型号
                'lens' => $lens,
                'size' => sprintf('%s * %s', data_get($exif, 'COMPUTED.Width'), data_get($exif, 'COMPUTED.Height')), // 照片尺寸
            ])->transform(fn ($item) => trim($item))->filter();
        });
    }

    public function url(): Attribute
    {
        return new Attribute(function () {
            return Storage::disk(config('app.photo_disk'))->url($this->pathname);
        });
    }

    public function thumbnailUrl(): Attribute
    {
        return new Attribute(function () {
            return Storage::disk(config('app.thumbnail_disk'))->url($this->thumbnail_pathname);
        });
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }
}
