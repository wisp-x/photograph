<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function index(): View
    {
        $albums = Album::query()->with('photos')->paginate(20);

        return view('index', compact('albums'));
    }

    public function photo(Request $request): View
    {
        $callback = fn () => abort(404);
        /** @var Album $album */
        $album = Album::query()->with('photos')->findOr($request->route('id'), $callback);
        /** @var Photo $photo */
        $photo = $album->photos()->where('md5', $request->route('hash'))->firstOr($callback);

        $album->increment('views');
        $photo->increment('views');

        return view('photo', compact('album', 'photo'));
    }
}
