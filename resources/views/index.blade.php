@extends('layouts.app')

@section('content')
    <div class="bg-black/80 text-gray-100 h-full min-h-screen">
        <div class="max-w-screen-md md:max-w-screen-lg mx-auto">
            <section class="flex flex-col w-full pt-20 pb-24 p-4 space-y-20">

                @foreach($albums as $album)
                    <div class="w-full flex flex-col">
                        <div class="space-y-2">
                            <h1 class="text-md font-semibold text-gray-200 md:mr-1">{{ $album->name }}</h1>
                            <time class="text-xs italic text-gray-500 text-right">{{ $album->created_at->format('Y-m-d') }}</time>
                            @if($album->intro)
                                <p class="text-sm text-gray-400">{{ $album->intro }}</p>
                            @endif
                        </div>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($album->photos->sortByDesc('weigh') as $photo)
                                <div @class(['relative w-full overflow-hidden group', 'col-span-1 md:col-span-2 lg:col-span-4 md:max-h-96' => $loop->first, 'md:h-32' => ! $loop->first])>
                                    <a href="{{ route('photo', ['id' => $album->id, 'hash' => $photo->md5, 'back_url' => base64_encode(request()->fullUrl())]) }}">
                                        <img class="w-full h-full object-center object-cover shadow-xl rounded-xl" alt="{{ $photo->intro }}" src="{{ $photo->thumbnail_url }}">
                                    </a>
                                    <div class="w-full transition-all absolute bottom-0 md:-bottom-10 md:group-hover:bottom-0">
                                        <p class="w-full p-2 truncate text-sm text-gray-300">{{ $photo->intro }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </section>

            <div class="px-4 mt-2 pb-10">
                {{ $albums->links('vendor.pagination.app') }}
            </div>
        </div>
        <div class="text-center text-gray-400 text-sm py-4">
            &copy; 2022 - {{ date('Y') }} | Copyright by <a target="_blank" href="https://github.com/wisp-x">Wisp X</a>
        </div>
    </div>
@endsection
