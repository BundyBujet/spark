@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('PAGINATION_NAV') }}" class="mt-6">
        {{-- Mobile: prev / next only --}}
        <div class="flex items-center justify-between gap-3 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex min-w-[100px] items-center justify-center rounded-lg border border-[#e0e6ed] bg-white px-4 py-2.5 text-sm font-medium text-white-dark/70 dark:border-[#1b2e4b] dark:bg-[#0e1726]">
                    <i class="ri-arrow-left-s-line ltr:mr-1 rtl:ml-1 rtl:rotate-180"></i>{{ __('PAGINATION_PREVIOUS') }}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex min-w-[100px] items-center justify-center rounded-lg border border-[#e0e6ed] bg-white px-4 py-2.5 text-sm font-medium text-dark transition-all duration-200 hover:border-primary/30 hover:bg-primary/5 hover:text-primary dark:border-[#1b2e4b] dark:bg-[#0e1726] dark:text-white-light dark:hover:border-primary/40">
                    <i class="ri-arrow-left-s-line ltr:mr-1 rtl:ml-1 rtl:rotate-180"></i>{{ __('PAGINATION_PREVIOUS') }}
                </a>
            @endif
            <span class="text-sm text-white-dark">
                {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
            </span>
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex min-w-[100px] items-center justify-center rounded-lg border border-[#e0e6ed] bg-white px-4 py-2.5 text-sm font-medium text-dark transition-all duration-200 hover:border-primary/30 hover:bg-primary/5 hover:text-primary dark:border-[#1b2e4b] dark:bg-[#0e1726] dark:text-white-light dark:hover:border-primary/40">
                    {{ __('PAGINATION_NEXT') }}<i class="ri-arrow-right-s-line ltr:ml-1 rtl:mr-1 rtl:rotate-180"></i>
                </a>
            @else
                <span class="inline-flex min-w-[100px] items-center justify-center rounded-lg border border-[#e0e6ed] bg-white px-4 py-2.5 text-sm font-medium text-white-dark/70 dark:border-[#1b2e4b] dark:bg-[#0e1726]">
                    {{ __('PAGINATION_NEXT') }}<i class="ri-arrow-right-s-line ltr:ml-1 rtl:mr-1 rtl:rotate-180"></i>
                </span>
            @endif
        </div>

        {{-- Desktop: info + full pagination --}}
        <div class="hidden sm:block">
            <div class="flex flex-col gap-4 md:flex-row md:items-center justify-between items-center">
                <p class="text-sm text-white-dark dark:text-white-dark">
                    {{ __('PAGINATION_SHOWING') }}
                    @if ($paginator->firstItem())
                        <span class="font-semibold text-dark dark:text-white-light">{{ $paginator->firstItem() }}</span>
                        {{ __('PAGINATION_TO') }}
                        <span class="font-semibold text-dark dark:text-white-light">{{ $paginator->lastItem() }}</span>
                    @else
                        <span class="font-semibold text-dark dark:text-white-light">{{ $paginator->count() }}</span>
                    @endif
                    {{ __('PAGINATION_OF') }}
                    <span class="font-semibold text-dark dark:text-white-light">{{ $paginator->total() }}</span>
                    {{ __('PAGINATION_RESULTS') }}
                </p>

                <div class="inline-flex items-center gap-1 rounded-lg border border-[#e0e6ed] bg-white p-1 shadow-sm dark:border-[#1b2e4b] dark:bg-[#0e1726]">
                    {{-- Previous --}}
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-md text-white-dark/50 dark:text-white-dark/50" aria-hidden="true">
                            <i class="ri-arrow-left-s-line text-lg rtl:rotate-180"></i>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-nav inline-flex h-9 w-9 items-center justify-center rounded-md text-white-dark transition-all duration-200 hover:scale-105 hover:bg-primary/10 hover:text-primary dark:hover:bg-primary/20" aria-label="{{ __('PAGINATION_PREVIOUS') }}">
                            <i class="ri-arrow-left-s-line text-lg rtl:rotate-180"></i>
                        </a>
                    @endif

                    {{-- Page numbers --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="inline-flex h-9 min-w-[2.25rem] items-center justify-center px-2 text-white-dark" aria-hidden="true">…</span>
                        @endif
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="pagination-page inline-flex h-9 min-w-[2.25rem] items-center justify-center rounded-md bg-primary px-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 dark:bg-primary dark:text-white" aria-label="{{ __('PAGINATION_PAGE', ['page' => $page]) }}">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="pagination-page inline-flex h-9 min-w-[2.25rem] items-center justify-center rounded-md px-2.5 text-sm font-medium text-dark transition-all duration-200 hover:scale-105 hover:bg-primary/10 hover:text-primary dark:text-white-light dark:hover:bg-primary/20 dark:hover:text-primary" aria-label="{{ __('PAGINATION_PAGE', ['page' => $page]) }}">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-nav inline-flex h-9 w-9 items-center justify-center rounded-md text-white-dark transition-all duration-200 hover:scale-105 hover:bg-primary/10 hover:text-primary dark:hover:bg-primary/20" aria-label="{{ __('PAGINATION_NEXT') }}">
                            <i class="ri-arrow-right-s-line text-lg rtl:rotate-180"></i>
                        </a>
                    @else
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-md text-white-dark/50 dark:text-white-dark/50" aria-hidden="true">
                            <i class="ri-arrow-right-s-line text-lg rtl:rotate-180"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </nav>
@endif
