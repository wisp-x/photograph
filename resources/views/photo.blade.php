@extends('layouts.app')

@section('content')
    <div class="bg-black/80 text-gray-100 h-screen relative inset-0 w-full bg-center" style="background-image: url({{ $photo->url }})">
        <div class="flex flex-col justify-between w-full h-full transform-gpu backdrop-blur-xl backdrop-brightness-50">
            <header class="flex w-full p-4 bg-black/20">
                <a href="{{ request()->has('back_url') ? base64_decode(request('back_url')) : route('home') }}" class="flex items-center justify-center h-8 w-8 rounded-full transition-all bg-gray-500/60 hover:bg-gray-600/50">
                    <x-icons.back class="fill-gray-200"></x-icons.back>
                </a>
            </header>

            <main class="flex-1 items-center h-[70%] w-full p-10">
                <div class="flex flex-col gap-3 h-full">
                    <div class="grow flex justify-center items-center w-full h-full overflow-hidden">
                        <img id="photo" class="max-h-full object-contain object-center rounded-md shadow-xl" alt="{{ $photo->intro }}" src="{{ $photo->url }}">
                    </div>
                    <div class="flex flex-col items-center w-full">
                        @if($photo->data->isNotEmpty())
                        <div class="flex flex-col md:flex-row gap-2 md:gap-8 text-white/40 text-sm">
                            @if($photo->data->has('camera'))
                                <p class="flex items-center space-x-1.5" title="相机型号">
                                    <x-icons.camera width="14" height="14" class="fill-white/40"></x-icons.camera>
                                    <span>{{ $photo->data->get('camera') }}</span>
                                </p>
                            @endif
                            @if($photo->data->has('lens_model'))
                                <p class="flex items-center space-x-1.5" title="镜头型号">
                                    <x-icons.lens width="14" height="14" class="fill-white/40"></x-icons.lens>
                                    <span>{{ $photo->data->get('lens_model') }}</span>
                                </p>
                            @endif
                            @if($photo->data->has('lens'))
                                <p class="flex items-center space-x-1.5" title="镜头参数">
                                    <x-icons.aperture width="14" height="14" class="fill-white/40"></x-icons.aperture>
                                    <span>{{ $photo->data->get('lens') }}</span>
                                </p>
                            @endif
                        </div>
                        @endif
                        @if($photo->intro)
                        <div class="w-full mt-6 font-serif tracking-wide md:text-center text-white/80">
                            {{ $photo->intro }}
                        </div>
                        @endif
                    </div>
                </div>
            </main>

            <footer class="flex w-full h-20 p-2 bg-black/20 overflow-y-hidden overflow-x-auto gap-2 snap-x snap-mandatory">
                @foreach($album->photos->sortByDesc('weigh') as $item)
                    <a href="{{ route('photo', ['id' => $album->id, 'hash' => $item->md5]) }}" @class(['snap-center shrink-0 h-full transition-all border-2 hover:border-gray-200 rounded-md shadow-md overflow-hidden', 'border-transparent' => $item->id !== $photo->id])>
                        <img class="h-full object-contain object-center" alt="{{ $item->intro }}" src="{{ $item->thumbnail_url }}">
                    </a>
                @endforeach
            </footer>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="module">
        const viewer = new Viewer(document.getElementById('photo'), {
            navbar: false,
            toolbar: {
                zoomIn: true,
                zoomOut: true,
                oneToOne: true,
                reset: true,
                prev: false,
                play: {
                    show: false,
                    size: 'large',
                },
                next: false,
                rotateLeft: true,
                rotateRight: true,
                flipHorizontal: true,
                flipVertical: true,
            },
            title: [true, function (image, imageData) {
                return image.alt;
            }]
        });
    </script>
@endpush
