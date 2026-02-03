<!-- start sidebar section -->
<div :class="{ 'dark text-white-dark': $store.app.semidark }">
    <nav x-data="sidebar"
        class="sidebar fixed bottom-0 top-0 z-50 h-full min-h-screen w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-all duration-300">
        <div class="h-full bg-white dark:bg-[#0e1726]">
            <div class="flex justify-between items-center px-4 py-3">
                <span class="flex items-center main-logo shrink-0">
                    <img class="ml-[5px] w-8 flex-none rounded-full" src="{{asset("assets/images/g-8.png")}}" alt="image" />
                    <span
                        class="text-2xl font-semibold align-middle ltr:ml-1.5 rtl:mr-1.5 dark:text-white-light lg:inline">Starter
                        Kit</span>
                </span>
                <a href="javascript:;"
                    class="flex items-center w-8 h-8 rounded-full transition duration-300 collapse-icon hover:bg-gray-500/10 rtl:rotate-180 dark:text-white-light dark:hover:bg-dark-light/10"
                    @click="$store.app.toggleSidebar()">
                    <svg class="m-auto w-5 h-5" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
            <x-sidebar.sidebar-menu />
        </div>
    </nav>
</div>
<!-- end sidebar section -->
