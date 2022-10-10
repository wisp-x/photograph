<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Support\Facades\DB;

class AlbumService
{
    /**
     * 储存相册数据
     *
     * @param array $validated 验证器通过后的数据
     * @return void
     */
    public function store(array $validated): void
    {
        DB::transaction(function () use ($validated) {
            $album = new Album([
                'name' => $validated['name'],
                'intro' => $validated['intro'],
            ]);
            $album->save();
            $photos = array_values($validated['photos']);
            foreach ($photos as $index => $photo) {
                Photo::query()->where('id', $photo['id'])->update(array_merge([
                    'album_id' => $album->id,
                    'weigh' => count($photos) - $index,
                ], ['intro' => $photo['intro']]));
            }
        });
    }

    /**
     * 更新相册数据
     *
     * @param Album $album
     * @param array $validated 验证器通过后的数据
     * @return void
     */
    public function update(Album $album, array $validated): void
    {
        DB::transaction(function () use ($album, $validated) {
            $album->fill([
                'name' => $validated['name'],
                'intro' => $validated['intro'],
            ])->save();
            $photos = array_values($validated['photos']);
            foreach ($photos as $index => $photo) {
                Photo::query()->where('id', $photo['id'])->update(array_merge([
                    'album_id' => $album->id,
                    'weigh' => count($photos) - $index,
                ], ['intro' => $photo['intro']]));
            }
        });
    }

    /**
     * 删除相册
     *
     * @param array $keys
     * @return int
     */
    public function destroy(array $keys): int
    {
        $i = 0;

        Album::query()->whereIn('id', $keys)->cursor()->each(function (Album $album) use (&$i) {
            if ($album->delete()) {
                $i++;
            }
        });

        return $i;
    }
}
