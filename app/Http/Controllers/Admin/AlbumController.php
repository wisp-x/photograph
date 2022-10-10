<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlbumRequest;
use App\Models\Album;
use App\Services\AlbumService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AlbumController extends Controller
{
    public function index(): View
    {
        $albums = Album::query()->has('photos')->with('photos')->withCount('photos')->latest()->paginate(20);
        return view('admin.album.index', compact('albums'));
    }

    public function create(): View
    {
        return view('admin.album.create');
    }

    public function store(AlbumRequest $request, AlbumService $service): RedirectResponse
    {
        $service->store($request->validated());
        return redirect(route('albums.index'))->with([
            'message' => ['type' => 'success', 'content' => '相册创建成功'],
        ]);
    }

    public function edit(Album $album): View
    {
        $album->photos->append(['url', 'thumbnail_url']);
        return view('admin.album.edit', compact('album'));
    }

    public function update(AlbumRequest $request, Album $album, AlbumService $service): RedirectResponse
    {
        $service->update($album, $request->validated());
        return redirect(route('albums.edit', ['album' => $album->id]))->with([
            'message' => ['type' => 'success', 'content' => '修改成功'],
        ]);
    }

    public function destroy(Album $album, AlbumService $service)
    {
        $service->destroy([$album->id]);
    }
}
