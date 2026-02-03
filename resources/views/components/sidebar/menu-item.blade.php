@props(['href', 'label', 'icon' => null])

<li class="nav-item">
    <a href="{{ $href }}" class="nav-link">
        <div class="flex items-center">
            @if($icon)
                @if(str_starts_with($icon, '<svg') || str_starts_with($icon, '<i'))
                    <span class="shrink-0">{!! $icon !!}</span>
                @else
                    <i class="text-xl {{ $icon }}"></i>
                @endif
            @endif
            <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">
                {{ __($label) }}
            </span>
        </div>
    </a>
</li>
