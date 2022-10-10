<div class="relative group photo-item">
    <a href="javascript:void(0)" class="absolute -top-4 -right-4 hidden group-hover:block photo-remove" data-id="{{ $photo['id'] }}">
        <x-icons.close width="35" height="35" class="fill-red-500"></x-icons.close>
    </a>

    <div class="flex gap-2 h-24">
        <div class="h-full w-24 cursor-grab">
            <img class="h-full w-full rounded-md object-center object-cover" data-url="{{ $photo['url'] }}" src="{{ $photo['thumbnail_url'] }}" alt="{{ $photo['filename'] }}">
        </div>
        <x-textarea name="photos[{{ $index }}][intro]" class="resize-none h-full" rows="100%" placeholder="说说此照片的来历或拍摄时的心情吧～可为空">{{ $photo['intro'] }}</x-textarea>
    </div>

    <input type="hidden" name="photos[{{ $index }}][id]" value="{{ $photo['id'] }}">
    <input type="hidden" name="photos[{{ $index }}][filename]" value="{{ $photo['filename'] }}">
    <input type="hidden" name="photos[{{ $index }}][thumbnail_url]" value="{{ $photo['thumbnail_url'] }}">
    <input type="hidden" name="photos[{{ $index }}][url]" value="{{ $photo['url'] }}">
</div>
