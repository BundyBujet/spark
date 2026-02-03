@props(['items' => []])

@if(count($items) > 0)
    <ul class="flex space-x-2 rtl:space-x-reverse mb-4">
        @foreach($items as $index => $item)
            <li class="{{ $index > 0 ? 'before:content-[\'/\'] before:px-1.5 ltr:before:mr-1 rtl:before:ml-1' : '' }}">
                @if(isset($item['route']) && !$loop->last)
                    <a href="{{ route($item['route']) }}"
                       class="text-gray-500 hover:text-gray-500/70 hover:text-primary hover:underline">
                        {{ __($item['label']) }}
                    </a>
                @else
                    <span class="text-black hover:text-black/70 dark:text-white-light dark:hover:text-white-light/70">
                        {{ __($item['label']) }}
                    </span>
                @endif
            </li>
        @endforeach
    </ul>
@endif
