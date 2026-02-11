@props([
    'tags' => collect(),
    'selectedIds' => [],
    'name' => 'tags',
    'label' => null,
    'error' => null,
])
@php
    $selectedIds = array_values(array_map('intval', (array) $selectedIds));
    $tagsData = $tags->map(function ($t) {
        $tagName = strtolower($t->name);
        $iconClass = match(true) {
            str_contains($tagName, 'work') => 'ri-briefcase-4-line',
            str_contains($tagName, 'personal') => 'ri-user-line',
            str_contains($tagName, 'important') => 'ri-star-line',
            str_contains($tagName, 'social') => 'ri-team-line',
            default => 'ri-price-tag-3-line',
        };
        return ['id' => $t->id, 'name' => $t->name, 'iconClass' => $iconClass];
    })->values()->all();
    $inputName = $name . '[]';
@endphp
<div
    x-data="{
        open: false,
        selected: @js($selectedIds),
        tagSearch: '',
        tags: @js($tagsData),
        get filteredTags() {
            if (!this.tagSearch.trim()) return this.tags;
            const q = this.tagSearch.toLowerCase();
            return this.tags.filter(t => t.name.toLowerCase().includes(q));
        },
        isSelected(id) { return this.selected.includes(id); },
        toggle(id) {
            if (this.selected.includes(id)) {
                this.selected = this.selected.filter(i => i !== id);
            } else {
                this.selected = [...this.selected, id].sort((a,b) => a - b);
            }
        },
        syncToHidden() {
            const container = this.$refs.tagsInputsContainer;
            container.innerHTML = '';
            this.selected.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = '{{ $inputName }}';
                input.value = id;
                container.appendChild(input);
            });
            this.open = false;
        }
    }"
    @keydown.escape.window="if (open) open = false"
    class="items-tag-selector">
    @if ($label !== null)
        <label for="tags-trigger" class="block text-sm font-semibold mb-2 dark:text-white-light">{{ $label }}</label>
    @else
        <label for="tags-trigger" class="block text-sm font-semibold mb-2 dark:text-white-light">{{ __('ITEMS_TAGS') }}</label>
    @endif
    <div class="flex flex-wrap items-center gap-2">
        <button
            type="button"
            id="tags-trigger"
            @click="open = true"
            class="btn btn-outline-primary inline-flex items-center gap-2 transition-all duration-200 hover:scale-[1.02]">
            <i class="ri-price-tag-3-line"></i>
            <span>{{ __('ITEMS_TAGS_SELECT') }}</span>
            <span x-show="selected.length > 0" x-cloak class="text-xs opacity-80" x-text="selected.length + ' {{ __('ITEMS_TAGS_SELECTED') }}'"></span>
        </button>
    </div>
    <div x-ref="tagsInputsContainer" data-input-name="{{ $inputName }}">
        @foreach ($selectedIds as $id)
            <input type="hidden" name="{{ $inputName }}" value="{{ $id }}">
        @endforeach
    </div>
    @if ($error)
        <div class="text-danger mt-1 text-sm">{{ $error }}</div>
    @endif

    {{-- Modal --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60"
        @click.self="open = false">
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="panel w-full max-w-lg rounded-xl border border-[#e0e6ed] bg-white shadow-xl dark:border-[#1b2e4b] dark:bg-[#0e1726]"
            @click.stop>
            <div class="flex items-start justify-between border-b border-[#e0e6ed] p-5 dark:border-[#1b2e4b]">
                <div>
                    <h3 class="text-lg font-semibold text-dark dark:text-white-light">{{ __('ITEMS_TAGS') }}</h3>
                    <p class="mt-1 text-sm text-white-dark">{{ __('ITEMS_TAGS_MODAL_SUBTITLE') }}</p>
                </div>
                <button type="button" @click="open = false" class="rounded-md p-1.5 text-white-dark transition hover:bg-white-dark/10 hover:text-dark dark:hover:bg-[#181F32] dark:hover:text-white-light" aria-label="{{ __('CANCEL') }}">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>
            <div class="p-5">
                <div class="relative mb-4">
                    <i class="ri-search-line absolute top-1/2 ltr:left-3 rtl:right-3 h-4 w-4 -translate-y-1/2 text-white-dark"></i>
                    <input
                        type="text"
                        x-model="tagSearch"
                        placeholder="{{ __('ITEMS_TAGS_SEARCH_PLACEHOLDER') }}"
                        class="form-input w-full rounded-lg ltr:pl-10 rtl:pr-10 rtl:pl-4 ltr:rtl:pr-4">
                </div>
                <div class="max-h-[280px] overflow-y-auto rounded-lg border border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                    <div class="flex flex-wrap gap-2" x-data>
                        <template x-for="tag in filteredTags" :key="tag.id">
                            <button
                                type="button"
                                @click="toggle(tag.id)"
                                :class="isSelected(tag.id) ? 'bg-primary text-white border-primary dark:bg-primary dark:text-white' : 'border-[#e0e6ed] bg-white text-dark hover:border-primary/30 hover:bg-primary/5 dark:border-[#1b2e4b] dark:bg-[#0e1726] dark:text-white-light dark:hover:bg-primary/20'"
                                class="inline-flex items-center gap-2 rounded-lg border px-3 py-2 text-sm font-medium transition-all duration-200 hover:scale-105">
                                <i :class="tag.iconClass" class="shrink-0 text-base"></i>
                                <span x-text="tag.name"></span>
                            </button>
                        </template>
                        <template x-if="filteredTags.length === 0">
                            <p class="py-4 text-sm text-white-dark">{{ __('ITEMS_TAGS_NO_MATCH') }}</p>
                        </template>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-2 border-t border-[#e0e6ed] p-5 dark:border-[#1b2e4b]">
                <button type="button" @click="open = false" class="btn btn-outline-secondary">{{ __('CANCEL') }}</button>
                <button type="button" @click="syncToHidden()" class="btn btn-primary">{{ __('ITEMS_TAGS_DONE') }}</button>
            </div>
        </div>
    </div>
</div>
