<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/g-8.png') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    {{-- Main CSS styles --}}
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/perfect-scrollbar.min.css') }}" />
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/style.css') }}" />
    <link defer rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/flatpickr.min.css') }}" />
    {{-- JS Deferred  script for packages --}}
    <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/tippy-bundle.umd.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <style>
        :is([dir="ltr"] .swal2-popup .swal2-html-container) {
            padding-right: 0 !important;
        }
    </style>
    @yield('css')
</head>

<body x-data="main" class="overflow-x-hidden relative text-sm antialiased font-normal font-nunito"
    :class="[$store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme === 'dark' || $store.app.isDarkMode ? 'dark' : '',
        $store.app.menu, $store.app.layout, $store.app.rtlClass
    ]">
    <!-- Layout wrapper -->
    <div x-cloak class="fixed inset-0 z-50 bg-[black]/60 lg:hidden" :class="{ 'hidden': !$store.app.sidebar }"
        @click="$store.app.toggleSidebar()"></div>
    @include('layouts.screenLoader')
    @include('layouts.scrollToTop')

    <div class="min-h-screen text-black main-container dark:text-white-dark" :class="[$store.app.navbar]">
        <!-- The Sidebar  -->
        @include('layouts.sidebar')

        <div class="flex flex-col min-h-screen main-content">
            <!-- The Header -->
            @include('layouts.navbar')

            <!-- The Main Content -->
            <div class="flex-1 p-6 main-content-body">
                @include('layouts.flashMessage')
                @yield('content')
            </div>

            <!-- The Footer -->
            @include('layouts.footer')
        </div>
    </div>


    {{-- Main Dashboard JS --}}
    <script src="{{ asset('assets/js/alpine-collaspe.min.js') }}"></script>
    <script src="{{ asset('assets/js/alpine-persist.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/alpine-ui.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/alpine-focus.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/alpine.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    {{-- Main Master Script for config --}}
    @include('layouts.masterScript')
    @yield('js')
</body>

</html>
