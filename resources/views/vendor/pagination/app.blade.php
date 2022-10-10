@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center p-3 text-sm font-medium text-gray-400 bg-gray-500/50 cursor-default leading-5 rounded-full">
                    <x-icons.previous class="fill-gray-400"></x-icons.previous>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center p-3 text-sm font-medium text-gray-700 bg-gray-100 leading-5 rounded-full hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 transition ease-in-out duration-150">
                    <x-icons.previous class="fill-gray-700"></x-icons.previous>
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center p-3 ml-3 text-sm font-medium text-gray-700 bg-gray-100 leading-5 rounded-full hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 transition ease-in-out duration-150">
                    <x-icons.next class="fill-gray-700"></x-icons.next>
                </a>
            @else
                <span class="relative inline-flex items-center p-3 ml-3 text-sm font-medium text-gray-400 bg-gray-500/50 cursor-default leading-5 rounded-full">
                    <x-icons.next class="fill-gray-400"></x-icons.next>
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md space-x-2">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center p-2 text-sm font-medium bg-gray-500/50 cursor-default rounded-md leading-5" aria-hidden="true">
                                <x-icons.previous class="fill-gray-500"></x-icons.previous>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center p-2 text-sm font-medium bg-gray-500/50 rounded-md leading-5 hover:text-gray-100 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
                            <x-icons.previous class="fill-gray-100"></x-icons.previous>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-gray-200 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-gray-600/50 cursor-default leading-5 rounded-md">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-100 bg-gray-500/50 rounded-md leading-5 hover:text-gray-100 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center p-2 -ml-px text-sm font-medium bg-gray-500/50 rounded-md leading-5 hover:text-gray-100 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
                            <x-icons.next class="fill-gray-100"></x-icons.next>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium bg-gray-500/50 cursor-default rounded-md leading-5" aria-hidden="true">
                                <x-icons.next class="fill-gray-500"></x-icons.next>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
