<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property null|string $intro
 * @property int $views
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property-read Collection $photos
 */
class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'intro',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class, 'album_id', 'id');
    }
}
