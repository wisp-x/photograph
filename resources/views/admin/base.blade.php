@extends('layouts.app')

@section('content')
    <div class="container max-w-screen-md mx-auto p-6 mt-10">
        <div class="flex items-center justify-between">
            <div class="flex space-x-2">
                @foreach($_tabs as $tab)
                <a href="{{ route($tab['value']) }}" @class(['transition-all rounded-md text-sm px-3 py-1.5', 'bg-gray-200 text-gray-700 hover:bg-gray-300' => ! $tab['is_active'], 'bg-gray-500 text-white' => $tab['is_active']])>{{ $tab['name'] }}</a>
                @endforeach
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('home') }}" class="text-sm text-gray-600">首页<a>
                <a href="{{ route('logout') }}" class="text-sm text-red-500">退出</a>
            </div>
        </div>

        <main class="pt-6">
            @yield('main')
        </main>
    </div>
@endsection
