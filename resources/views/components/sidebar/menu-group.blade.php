@props(['id', 'label', 'icon', 'items' => []])

<li class="menu nav-item" x-data="{ isOpen: false }">
    <button
        type="button"
        class="nav-link group"
        @click="isOpen = !isOpen"
    >
        <div class="flex items-center">
            @if($icon)
                @if(str_starts_with($icon, '<svg'))
                    <span class="shrink-0">{!! $icon !!}</span>
                @else
                    <i class="text-xl {{ $icon }} shrink-0 group-hover:!text-primary"></i>
                @endif
            @endif
            <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">
                {{ __($label) }}
            </span>
        </div>
        <div class="rtl:rotate-180" :class="{ '!rotate-90': isOpen }">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
    </button>
    <ul x-cloak x-show="isOpen" x-collapse class="sub-menu text-gray-500">
        @foreach($items as $item)
            <li>
                <a href="{{ route($item['route']) }}">
                    {{ __($item['label']) }}
                </a>
            </li>
        @endforeach
    </ul>
</li>
