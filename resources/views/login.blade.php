@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center w-full h-screen">
        <form action="" method="post">
            @csrf
            <x-errors class="pl-6 mb-2"></x-errors>

            <label>
                <input type="password" name="password" class="rounded-full border px-3 py-2" placeholder="请输入密码后回车" />
            </label>
        </form>
    </div>
@endsection
