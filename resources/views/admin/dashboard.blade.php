@extends('admin.base')

@section('main')
    <div class="text-gray-500 space-y-2">
        <p>系统共有 {{ $albumCount }} 个相册，{{ $photoCount }} 张图片。</p>
        @if($firstAlbum && $firstPhoto)
            <p>其中访问次数最多({{ $firstAlbum->views }}次)的相册是 <b>{{ $firstAlbum->name }}</b>，发布于 {{ $firstAlbum->created_at }}</p>
            <p>点击次数({{ $firstPhoto->views }} 次)最多图片是 <a class="text-blue-700" href="{{ $firstPhoto->url }}" target="_blank">点击查看</a>
        @endif
    </div>
@endsection
