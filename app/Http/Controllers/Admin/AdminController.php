<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $albumCount = Album::query()->count();
        $photoCount = Photo::query()->count();
        $firstAlbum = Album::query()->orderByDesc('views')->first();
        $firstPhoto = Photo::query()->orderByDesc('views')->first();

        return view('admin.dashboard', compact('albumCount', 'photoCount', 'firstAlbum', 'firstPhoto'));
    }
}
