@if(session()->has('message'))
    <x-alert class="{{ session()->get('message.type') }}">{{ session()->get('message.content') }}</x-alert>
@endif
