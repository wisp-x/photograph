@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'text-red-500 text-sm']) }}>
        <ul class="list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
