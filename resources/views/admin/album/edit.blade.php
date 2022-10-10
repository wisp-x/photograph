@extends('admin.base')

@section('main')
    <x-message></x-message>
    <x-errors class="pl-4 mb-2"></x-errors>

    <form action="{{ route('albums.update', ['album' => $album->id]) }}" method="post">
        @csrf
        <div class="mb-6">
            <x-label for="name">相册名称<small class="text-red-500">*</small></x-label>
            <x-input type="text" id="name" name="name" value="{{ $album->name }}" placeholder="请输入相册名称" required></x-input>
        </div>

        <div class="mb-6">
            <x-label for="intro">相册简介</x-label>
            <x-textarea id="intro" name="intro" placeholder="今儿的风甚是喧嚣～">{{ $album->intro }}</x-textarea>
        </div>

        <div class="mb-4">
            <x-label for="photos">选择照片<small class="text-red-500">*</small></x-label>
            <input type="file" id="photos" accept=".png,.jpg,.jpeg,.bmp,.webp" required multiple>
            <p class="text-xs text-gray-400 mt-2" id="upload-message">
                支持 png、jpg、bmp、webp，单次最多可以选择 20 张照片。
            </p>
        </div>

        <div class="mb-6">
            <div id="photo-items" class="flex flex-col gap-4">
                @foreach(array_merge($album->photos->sortByDesc('weigh')->toArray(), old('photos', [])) as $index => $photo)
                    @include('admin.album.photo-item', ['index' => $index, 'photo' => $photo])
                @endforeach
            </div>
        </div>

        <input type="hidden" name="_method" value="PUT">
        <div class="flex space-x-2">
            <x-button>确认修改</x-button>
        </div>
    </form>

@endsection

@include('admin.album.common')
