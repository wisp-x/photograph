@extends('admin.base')

@section('main')
    <x-message></x-message>

    <div class="flex space-x-2">
        <a href="{{ route('albums.create') }}" class="text-sm text-cyan-500 hover:text-cyan-600">发布新的</a>
    </div>
    <div class="flex flex-col divide-y divide-dashed">
        @if($albums->isEmpty())
            <p class="mt-2 text-center text-sm text-gray-400">还没有相册，点击左上角「发布新的」先创建一个吧～</p>
        @endif
        @foreach($albums as $album)
            <div class="flex flex-col space-y-0.5 py-3">
                <p class="text-gray-500 italic text-sm font-serif">
                    <span>{{ $album->photos_count }} 张照片</span>，
                    <span>发布于 <time title="{{ $album->created_at->format('Y-m-d H:i') }}">{{ $album->created_at->diffForHumans() }}</time></span>，
                    <span>共 {{ $album->views }} 次浏览</span>
                </p>
                <div class="flex items-center justify-between space-x-1">
                    <a href="{{ route('photo', ['id' => $album->id, 'hash' => $album->photos->sortByDesc('weigh')->first()->md5]) }}" target="_blank" class="grow truncate text-gray-700 hover:text-gray-800">{{ $album->name }}</a>
                    <div class="shrink-0 flex space-x-2">
                        <a href="{{ route('albums.edit', ['album' => $album->id]) }}" class="text-cyan-500 hover:text-cyan-700">编辑</a>
                        <a href="{{ route('albums.destroy', ['album' => $album->id]) }}" class="text-red-500 hover:text-red-700 destroy">删除</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $albums->links() }}
    </div>
@endsection

@push('scripts')
    <script type="module">
        $('.destroy').click(function (e) {
            e.preventDefault();
            if (confirm('确定要删除这个相册吗？')) {
                axios.delete(this.href).then(function () {
                    history.go(0);
                }).catch(function () {
                    alert('删除失败');
                });
            }
        });
    </script>
@endpush
