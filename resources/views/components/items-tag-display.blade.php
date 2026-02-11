@props(['tags' => collect()])
@if ($tags->isEmpty())
    <span class="text-sm text-white-dark">—</span>
@else
    <div class="flex flex-wrap gap-2">
        @foreach ($tags as $tag)
            <span class="inline-flex items-center gap-2 rounded-lg border border-primary bg-primary px-3 py-2 text-sm font-medium text-white transition-all duration-200 dark:bg-primary dark:text-white">
                <x-tag-icon :name="$tag->name" class="shrink-0 text-base" />
                <span>{{ $tag->name }}</span>
            </span>
        @endforeach
    </div>
@endif
