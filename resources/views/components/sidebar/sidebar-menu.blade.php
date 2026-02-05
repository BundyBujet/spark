@php
    // Menu configuration - easy to edit and extend
    $menuItems = [
        [
            'type' => 'link',
            'route' => 'admin.dashboard',
            'label' => 'ADMIN_PANEL',
            'icon' => 'ri-user-settings-fill'
        ],

        [
            'type' => 'link',
            'route' => 'items.index',
            'label' => 'ITEMS',
            'icon' => 'ri-list-check-2'
        ],
        [
            'type' => 'link',
            'route' => 'tags.index',
            'label' => 'TAGS',
            'icon' => 'ri-price-tag-3-line'
        ],
        [
            'type' => 'link',
            'route' => 'tasks.index',
            'label' => 'TASKS',
            'icon' => 'ri-checkbox-circle-line'
        ],
        [
            'type' => 'link',
            'route' => 'item-notifications.index',
            'label' => 'ITEM_NOTIFICATIONS',
            'icon' => 'ri-notification-3-line'
        ],
        [
            'type' => 'link',
            'route' => 'weekly-reports.index',
            'label' => 'WEEKLY_REPORTS',
            'icon' => 'ri-file-list-3-line'
        ],
        // [
        //     'type' => 'group',
        //     'id' => 'roles',
        //     'label' => 'ROLES',
        //     'icon' => '<svg class="shrink-0 group-hover:!text-primary" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        //         <path d="M8.42229 20.6181C10.1779 21.5395 11.0557 22.0001 12 22.0001V12.0001L2.63802 7.07275C2.62423 7.09491 2.6107 7.11727 2.5974 7.13986C2 8.15436 2 9.41678 2 11.9416V12.0586C2 14.5834 2 15.8459 2.5974 16.8604C3.19479 17.8749 4.27063 18.4395 6.42229 19.5686L8.42229 20.6181Z" fill="currentColor" />
        //         <path opacity="0.7" d="M17.5774 4.43152L15.5774 3.38197C13.8218 2.46066 12.944 2 11.9997 2C11.0554 2 10.1776 2.46066 8.42197 3.38197L6.42197 4.43152C4.31821 5.53552 3.24291 6.09982 2.6377 7.07264L11.9997 12L21.3617 7.07264C20.7564 6.09982 19.6811 5.53552 17.5774 4.43152Z" fill="currentColor" />
        //         <path opacity="0.5" d="M21.4026 7.13986C21.3893 7.11727 21.3758 7.09491 21.362 7.07275L12 12.0001V22.0001C12.9443 22.0001 13.8221 21.5395 15.5777 20.6181L17.5777 19.5686C19.7294 18.4395 20.8052 17.8749 21.4026 16.8604C22 15.8459 22 14.5834 22 12.0586V11.9416C22 9.41678 22 8.15436 21.4026 7.13986Z" fill="currentColor" />
        //     </svg>',
        //     'items' => [
        //         ['route' => 'roles.index', 'label' => 'ROLES'],
        //         ['route' => 'roles.create', 'label' => 'ADD_ROLE']
        //     ]
        // ],
        [
            'type' => 'link',
            'route' => 'telegram-storage.index',
            'label' => 'TELEGRAM_STORAGE',
            'icon' => 'ri-folder-upload-line'
        ],
    ];
@endphp

<ul class="perfect-scrollbar relative h-[calc(100vh-80px)] space-y-0.5 overflow-y-auto overflow-x-hidden p-4 py-0 font-semibold">
    @foreach($menuItems as $item)
        @if($item['type'] === 'link')
            @if(($item['route'] ?? '') === 'telegram-storage.index')
                @can('Manage Telegram Storage')
                    <x-sidebar.menu-item
                        :href="route($item['route'])"
                        :label="$item['label']"
                        :icon="$item['icon'] ?? null"
                    />
                @endcan
            @elseif(($item['route'] ?? '') === 'items.index')
                <x-sidebar.menu-item
                    :href="route($item['route'])"
                    :label="$item['label']"
                    :icon="$item['icon'] ?? null"
                />
            @elseif(($item['route'] ?? '') === 'tags.index')
                <x-sidebar.menu-item
                    :href="route($item['route'])"
                    :label="$item['label']"
                    :icon="$item['icon'] ?? null"
                />
            @elseif(($item['route'] ?? '') === 'tasks.index')
                <x-sidebar.menu-item
                    :href="route($item['route'])"
                    :label="$item['label']"
                    :icon="$item['icon'] ?? null"
                />
            @elseif(($item['route'] ?? '') === 'item-notifications.index')
                <x-sidebar.menu-item
                    :href="route($item['route'])"
                    :label="$item['label']"
                    :icon="$item['icon'] ?? null"
                />
            @elseif(($item['route'] ?? '') === 'weekly-reports.index')
                <x-sidebar.menu-item
                    :href="route($item['route'])"
                    :label="$item['label']"
                    :icon="$item['icon'] ?? null"
                />
            @else
                <x-sidebar.menu-item
                    :href="route($item['route'])"
                    :label="$item['label']"
                    :icon="$item['icon'] ?? null"
                />
            @endif
        @elseif($item['type'] === 'group')
            <x-sidebar.menu-group
                :id="$item['id']"
                :label="$item['label']"
                :icon="$item['icon'] ?? null"
                :items="$item['items']"
            />
        @endif
    @endforeach
</ul>
