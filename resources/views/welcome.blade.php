<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة تدريب - TADREEB | منصة التدريب التقني المتطورة</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="icon" href="favicon.ico">
</head>

<body class="bg-gray-900 text-white font-cairo overflow-x-hidden">
    <!-- Background Glowing Objects -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="glow-object glow-object-1 pulse-glow"></div>
        <div class="glow-object glow-object-2 pulse-glow"></div>
        <div class="glow-object glow-object-3 pulse-glow"></div>
        <div class="glow-object glow-object-4 pulse-glow"></div>
        <div class="glow-object glow-object-5 pulse-glow"></div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-10 bg-gray-900/80 backdrop-blur-md border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="#" class="flex items-center">
                        <img src="{{ asset('assets/images/logo/full-dark.png') }}" alt="TADREEB Logo"
                            class="h-12 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8 space-x-reverse">
                        <a href="#" class="text-orange-500 font-medium px-3 py-2 rounded-md text-sm">الرئيسية</a>
                        <a href="#features"
                            class="text-gray-300 hover:text-orange-500 px-3 py-2 rounded-md text-sm transition-colors">المميزات</a>
                        <a href="#pricing"
                            class="text-gray-300 hover:text-orange-500 px-3 py-2 rounded-md text-sm transition-colors">الأسعار</a>
                        <a href="#contact"
                            class="text-gray-300 hover:text-orange-500 px-3 py-2 rounded-md text-sm transition-colors">تواصل
                            معنا</a>
                        <a href="#blog" class="text-orange-500 font-medium px-3 py-2 rounded-md text-sm">المدونة</a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-gray-400 hover:text-white focus:outline-none focus:text-white">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative z-10 pt-20 pb-32 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center">
                <!-- Badge -->
                <div
                    class="inline-flex items-center px-6 py-3 rounded-full bg-orange-500/20 border-2 border-orange-400/40 mb-8 backdrop-blur-sm">
                    <span class="text-orange-300 text-sm font-semibold drop-shadow-md">منصة Work Simulation - محاكاة
                        العمل الحقيقي</span>
                </div>

                <!-- Main Headline - Slogan -->
                <h1 class="text-5xl md:text-6xl lg:text-8xl font-bold mb-8 leading-tight">
                    <span class="text-white drop-shadow-lg">اشتغل قبل ما</span>
                    <br>
                    <span class="text-orange-400 font-extrabold drop-shadow-2xl">تشتغل</span>
                </h1>

                <!-- Subtitle -->
                <h2 class="text-2xl md:text-3xl text-white mb-8 font-semibold drop-shadow-md">
                    أول منصة عربية لمحاكاة بيئة العمل الحقيقية
                </h2>

                <!-- Description -->
                <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-4xl mx-auto leading-relaxed">
                    منصة <strong class="text-orange-500">تدريب</strong> تربط الطلاب العرب بخبرة العمل الحقيقية من خلال
                    مشاريع واقعية،
                    إرشاد من الخبراء، وسوق لبيع المشاريع المنجزة.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
                    <a href="#pricing"
                        class="inline-flex items-center px-8 py-4 bg-orange-400 hover:bg-orange-300 text-white font-bold rounded-lg text-lg transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-orange-400/30 drop-shadow-lg">
                        ابدأ مجاناً
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    <a href="#contact"
                        class="inline-flex items-center px-8 py-4 border-2 border-orange-300 text-orange-300 hover:bg-orange-300 hover:text-white font-bold rounded-lg text-lg transition-all duration-300 drop-shadow-md">
                        احجز عرض توضيحي
                    </a>
                </div>

                <!-- Social Proof -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6 text-gray-400">
                    <div class="flex -space-x-2">
                        <img class="h-10 w-10 rounded-full border-2 border-gray-800"
                            src="{{ asset('assets/images/user/user-01.jpg') }}" alt="طالب">
                        <img class="h-10 w-10 rounded-full border-2 border-gray-800"
                            src="{{ asset('assets/images/user/user-02.jpg') }}" alt="طالب">
                        <img class="h-10 w-10 rounded-full border-2 border-gray-800"
                            src="{{ asset('assets/images/user/user-03.jpg') }}" alt="طالب">
                        <img class="h-10 w-10 rounded-full border-2 border-gray-800"
                            src="{{ asset('assets/images/user/user-04.jpg') }}" alt="طالب">
                        <img class="h-10 w-10 rounded-full border-2 border-gray-800"
                            src="{{ asset('assets/images/user/user-05.jpg') }}" alt="طالب">
                    </div>
                    <div class="text-center sm:text-right">
                        <p class="text-sm">أكثر من <span class="text-orange-500 font-semibold">5,000</span> طالب جامعي
                        </p>
                        <p class="text-xs text-gray-500">من <span class="text-orange-500">20+</span> جامعة عربية</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mentors Slider Section -->
    <section class="relative z-10 py-20 px-4 sm:px-6 lg:px-8 bg-gray-900">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-6">
                    <span class="text-white">خبراء</span>
                    <span class="text-orange-400"> المهندسين</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    تعرف على الخبراء الذين سيرشدونك في رحلتك نحو اكتساب الخبرة العملية الحقيقية
                </p>
            </div>

            <!-- Slider Container -->
            <div class="relative overflow-hidden">
                <!-- Slider Track -->
                <div class="flex animate-scroll gap-6 py-4" style="animation-duration: 30s;">
                    <!-- Mentor Card 1 -->
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-gray-800 rounded-lg p-6 h-full relative border border-gray-700">
                            <!-- Profile Image -->
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/user/user-01.jpg') }}" alt="أحمد محمد"
                                    class="w-full h-full object-cover grayscale">
                            </div>

                            <!-- Mentor Info -->
                            <div class="text-center mb-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-white">أحمد محمد</h3>
                                    <span class="text-sm">🇪🇬</span>
                                </div>
                                <p class="text-gray-400 text-sm">Frontend Web Developer</p>
                            </div>

                            <!-- Skills -->
                            <div class="space-y-1 mb-6">
                                <p class="text-white text-sm">React</p>
                                <p class="text-white text-sm">TypeScript</p>
                                <p class="text-white text-sm">Next.js</p>
                            </div>

                            <!-- Previously At -->
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <p class="text-gray-500 text-xs mb-2">PREVIOUSLY AT</p>
                                <div class="text-white font-semibold text-lg">Google</div>
                            </div>
                        </div>
                    </div>

                    <!-- Mentor Card 2 -->
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-gray-800 rounded-lg p-6 h-full relative border border-gray-700">
                            <!-- Profile Image -->
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/user/user-02.jpg') }}" alt="سارة علي"
                                    class="w-full h-full object-cover grayscale">
                            </div>

                            <!-- Mentor Info -->
                            <div class="text-center mb-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-white">سارة علي</h3>
                                    <span class="text-sm">🇪🇬</span>
                                </div>
                                <p class="text-gray-400 text-sm">Mobile Developer</p>
                            </div>

                            <!-- Skills -->
                            <div class="space-y-1 mb-6">
                                <p class="text-white text-sm">Android</p>
                                <p class="text-white text-sm">Kotlin</p>
                            </div>

                            <!-- Previously At -->
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <p class="text-gray-500 text-xs mb-2">PREVIOUSLY AT</p>
                                <div class="text-white font-semibold text-lg">Microsoft</div>
                            </div>
                        </div>
                    </div>

                    <!-- Mentor Card 3 -->
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-gray-800 rounded-lg p-6 h-full relative border border-gray-700">
                            <!-- Profile Image -->
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/user/user-03.jpg') }}" alt="محمد حسن"
                                    class="w-full h-full object-cover">
                            </div>

                            <!-- Mentor Info -->
                            <div class="text-center mb-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-white">محمد حسن</h3>
                                    <span class="text-sm">🇪🇬</span>
                                </div>
                                <p class="text-gray-400 text-sm">Full-Stack Web Developer</p>
                            </div>

                            <!-- Skills -->
                            <div class="space-y-1 mb-6">
                                <p class="text-white text-sm">React</p>
                                <p class="text-white text-sm">Python</p>
                                <p class="text-white text-sm">AWS</p>
                            </div>

                            <!-- Previously At -->
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <p class="text-gray-500 text-xs mb-2">PREVIOUSLY AT</p>
                                <div class="text-white font-semibold text-lg">Meta</div>
                            </div>
                        </div>
                    </div>

                    <!-- Mentor Card 4 -->
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-gray-800 rounded-lg p-6 h-full relative border border-gray-700">
                            <!-- Profile Image -->
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/user/user-04.jpg') }}" alt="فاطمة أحمد"
                                    class="w-full h-full object-cover grayscale">
                            </div>

                            <!-- Mentor Info -->
                            <div class="text-center mb-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-white">فاطمة أحمد</h3>
                                    <span class="text-sm">🇪🇬</span>
                                </div>
                                <p class="text-gray-400 text-sm">Game Developer</p>
                            </div>

                            <!-- Skills -->
                            <div class="space-y-1 mb-6">
                                <p class="text-white text-sm">Unity</p>
                                <p class="text-white text-sm">C#</p>
                                <p class="text-white text-sm">.Net</p>
                            </div>

                            <!-- Previously At -->
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <p class="text-gray-500 text-xs mb-2">PREVIOUSLY AT</p>
                                <div class="text-white font-semibold text-lg">SAMSUNG</div>
                            </div>
                        </div>
                    </div>

                    <!-- Mentor Card 5 -->
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-gray-800 rounded-lg p-6 h-full relative border border-gray-700">
                            <!-- Profile Image -->
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/user/user-05.jpg') }}" alt="علي محمود"
                                    class="w-full h-full object-cover grayscale">
                            </div>

                            <!-- Mentor Info -->
                            <div class="text-center mb-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-white">علي محمود</h3>
                                    <span class="text-sm">🇪🇬</span>
                                </div>
                                <p class="text-gray-400 text-sm">DevOps</p>
                            </div>

                            <!-- Skills -->
                            <div class="space-y-1 mb-6">
                                <p class="text-white text-sm">Kubernetes</p>
                                <p class="text-white text-sm">Terraform</p>
                                <p class="text-white text-sm">AWS</p>
                            </div>

                            <!-- Previously At -->
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <p class="text-gray-500 text-xs mb-2">PREVIOUSLY AT</p>
                                <div class="text-white font-semibold text-lg">NOKIA</div>
                            </div>
                        </div>
                    </div>

                    <!-- Mentor Card 6 -->
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-gray-800 rounded-lg p-6 h-full relative border border-gray-700">
                            <!-- Profile Image -->
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/user/user-06.jpg') }}" alt="نورا سعد"
                                    class="w-full h-full object-cover grayscale">
                            </div>

                            <!-- Mentor Info -->
                            <div class="text-center mb-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-white">نورا سعد</h3>
                                    <span class="text-sm">🇪🇬</span>
                                </div>
                                <p class="text-gray-400 text-sm">Full-Stack Developer</p>
                            </div>

                            <!-- Skills -->
                            <div class="space-y-1 mb-6">
                                <p class="text-white text-sm">PHP</p>
                                <p class="text-white text-sm">React</p>
                                <p class="text-white text-sm">Node.js</p>
                            </div>

                            <!-- Previously At -->
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <p class="text-gray-500 text-xs mb-2">PREVIOUSLY AT</p>
                                <div class="text-white font-semibold text-lg">BOEING</div>
                            </div>
                        </div>
                    </div>

                    <!-- Mentor Card 7 -->
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-gray-800 rounded-lg p-6 h-full relative border border-gray-700">
                            <!-- Profile Image -->
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/user/user-07.jpg') }}" alt="يوسف أحمد"
                                    class="w-full h-full object-cover grayscale">
                            </div>

                            <!-- Mentor Info -->
                            <div class="text-center mb-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-white">يوسف أحمد</h3>
                                    <span class="text-sm">🇪🇬</span>
                                </div>
                                <p class="text-gray-400 text-sm">Full-Stack Web Developer</p>
                            </div>

                            <!-- Skills -->
                            <div class="space-y-1 mb-6">
                                <p class="text-white text-sm">React</p>
                                <p class="text-white text-sm">Node.js</p>
                                <p class="text-white text-sm">Native</p>
                            </div>

                            <!-- Previously At -->
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <p class="text-gray-500 text-xs mb-2">PREVIOUSLY AT</p>
                                <div class="text-white font-semibold text-lg">VOLVO</div>
                            </div>
                        </div>
                    </div>

                    <!-- Duplicate cards for seamless loop -->
                    <!-- Mentor Card 1 Duplicate -->
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-gray-800 rounded-lg p-6 h-full relative border border-gray-700">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/user/user-01.jpg') }}" alt="أحمد محمد"
                                    class="w-full h-full object-cover grayscale">
                            </div>
                            <div class="text-center mb-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-white">أحمد محمد</h3>
                                    <span class="text-sm">🇪🇬</span>
                                </div>
                                <p class="text-gray-400 text-sm">Frontend Web Developer</p>
                            </div>
                            <div class="space-y-1 mb-6">
                                <p class="text-white text-sm">React</p>
                                <p class="text-white text-sm">TypeScript</p>
                                <p class="text-white text-sm">Next.js</p>
                            </div>
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <p class="text-gray-500 text-xs mb-2">PREVIOUSLY AT</p>
                                <div class="text-white font-semibold text-lg">Google</div>
                            </div>
                        </div>
                    </div>

                    <!-- Mentor Card 2 Duplicate -->
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-gray-800 rounded-lg p-6 h-full relative border border-gray-700">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/user/user-02.jpg') }}" alt="سارة علي"
                                    class="w-full h-full object-cover grayscale">
                            </div>
                            <div class="text-center mb-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-white">سارة علي</h3>
                                    <span class="text-sm">🇪🇬</span>
                                </div>
                                <p class="text-gray-400 text-sm">Mobile Developer</p>
                            </div>
                            <div class="space-y-1 mb-6">
                                <p class="text-white text-sm">Android</p>
                                <p class="text-white text-sm">Kotlin</p>
                            </div>
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <p class="text-gray-500 text-xs mb-2">PREVIOUSLY AT</p>
                                <div class="text-white font-semibold text-lg">Microsoft</div>
                            </div>
                        </div>
                    </div>

                    <!-- Mentor Card 3 Duplicate -->
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-gray-800 rounded-lg p-6 h-full relative border border-gray-700">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/user/user-03.jpg') }}" alt="محمد حسن"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="text-center mb-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-white">محمد حسن</h3>
                                    <span class="text-sm">🇪🇬</span>
                                </div>
                                <p class="text-gray-400 text-sm">Full-Stack Web Developer</p>
                            </div>
                            <div class="space-y-1 mb-6">
                                <p class="text-white text-sm">React</p>
                                <p class="text-white text-sm">Python</p>
                                <p class="text-white text-sm">AWS</p>
                            </div>
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <p class="text-gray-500 text-xs mb-2">PREVIOUSLY AT</p>
                                <div class="text-white font-semibold text-lg">Meta</div>
                            </div>
                        </div>
                    </div>

                    <!-- Mentor Card 4 Duplicate -->
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-gray-800 rounded-lg p-6 h-full relative border border-gray-700">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/user/user-04.jpg') }}" alt="فاطمة أحمد"
                                    class="w-full h-full object-cover grayscale">
                            </div>
                            <div class="text-center mb-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-white">فاطمة أحمد</h3>
                                    <span class="text-sm">🇪🇬</span>
                                </div>
                                <p class="text-gray-400 text-sm">Game Developer</p>
                            </div>
                            <div class="space-y-1 mb-6">
                                <p class="text-white text-sm">Unity</p>
                                <p class="text-white text-sm">C#</p>
                                <p class="text-white text-sm">.Net</p>
                            </div>
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <p class="text-gray-500 text-xs mb-2">PREVIOUSLY AT</p>
                                <div class="text-white font-semibold text-lg">SAMSUNG</div>
                            </div>
                        </div>
                    </div>

                    <!-- Mentor Card 5 Duplicate -->
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-gray-800 rounded-lg p-6 h-full relative border border-gray-700">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/user/user-05.jpg') }}" alt="علي محمود"
                                    class="w-full h-full object-cover grayscale">
                            </div>
                            <div class="text-center mb-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-white">علي محمود</h3>
                                    <span class="text-sm">🇪🇬</span>
                                </div>
                                <p class="text-gray-400 text-sm">DevOps</p>
                            </div>
                            <div class="space-y-1 mb-6">
                                <p class="text-white text-sm">Kubernetes</p>
                                <p class="text-white text-sm">Terraform</p>
                                <p class="text-white text-sm">AWS</p>
                            </div>
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <p class="text-gray-500 text-xs mb-2">PREVIOUSLY AT</p>
                                <div class="text-white font-semibold text-lg">NOKIA</div>
                            </div>
                        </div>
                    </div>

                    <!-- Mentor Card 6 Duplicate -->
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-gray-800 rounded-lg p-6 h-full relative border border-gray-700">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/user/user-06.jpg') }}" alt="نورا سعد"
                                    class="w-full h-full object-cover grayscale">
                            </div>
                            <div class="text-center mb-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-white">نورا سعد</h3>
                                    <span class="text-sm">🇪🇬</span>
                                </div>
                                <p class="text-gray-400 text-sm">Full-Stack Developer</p>
                            </div>
                            <div class="space-y-1 mb-6">
                                <p class="text-white text-sm">PHP</p>
                                <p class="text-white text-sm">React</p>
                                <p class="text-white text-sm">Node.js</p>
                            </div>
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <p class="text-gray-500 text-xs mb-2">PREVIOUSLY AT</p>
                                <div class="text-white font-semibold text-lg">BOEING</div>
                            </div>
                        </div>
                    </div>

                    <!-- Mentor Card 7 Duplicate -->
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-gray-800 rounded-lg p-6 h-full relative border border-gray-700">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden">
                                <img src="{{ asset('assets/images/user/user-07.jpg') }}" alt="يوسف أحمد"
                                    class="w-full h-full object-cover grayscale">
                            </div>
                            <div class="text-center mb-4">
                                <div class="flex items-center justify-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-white">يوسف أحمد</h3>
                                    <span class="text-sm">🇪🇬</span>
                                </div>
                                <p class="text-gray-400 text-sm">Full-Stack Web Developer</p>
                            </div>
                            <div class="space-y-1 mb-6">
                                <p class="text-white text-sm">React</p>
                                <p class="text-white text-sm">Node.js</p>
                                <p class="text-white text-sm">Native</p>
                            </div>
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <p class="text-gray-500 text-xs mb-2">PREVIOUSLY AT</p>
                                <div class="text-white font-semibold text-lg">VOLVO</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="relative z-10 py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-6">
                    <span class="text-white">مميزات منصة</span>
                    <span class="text-orange-500"> تدريب</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    أول منصة عربية تربط الطلاب بخبرة العمل الحقيقية من خلال مشاريع واقعية وإرشاد متخصص
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass-card glass-card-hover p-8 rounded-xl">
                    <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mb-6">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">محاكاة العمل الحقيقي</h3>
                    <p class="text-gray-300">مشاريع واقعية تحاكي بيئة العمل الفعلية، من مبتدئ إلى متقدم، مع متطلبات
                        واضحة ومواعيد نهائية.</p>
                </div>

                <!-- Feature 2 -->
                <div class="glass-card glass-card-hover p-8 rounded-xl border-2 border-orange-500/30">
                    <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mb-6">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">الإرشاد المتخصص</h3>
                    <p class="text-gray-300">إرشاد مباشر من الخبراء في المجال، مع نظام مراجعة المشاريع وتقييمات مفصلة
                        لتحسين مهاراتك.</p>
                </div>

                <!-- Feature 3 -->
                <div class="glass-card glass-card-hover p-8 rounded-xl">
                    <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mb-6">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">سوق المشاريع</h3>
                    <p class="text-gray-300">بيع المشاريع المنجزة كقوالب أو حزم، مع إمكانية كسب دخل إضافي من عملك.</p>
                </div>

                <!-- Feature 4 -->
                <div class="glass-card glass-card-hover p-8 rounded-xl">
                    <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mb-6">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">التكامل مع GitHub</h3>
                    <p class="text-gray-300">ربط مباشر مع GitHub لإنشاء مستودعات المشاريع تلقائياً ومتابعة التقدم
                        بسهولة.</p>
                </div>

                <!-- Feature 5 -->
                <div class="glass-card glass-card-hover p-8 rounded-xl">
                    <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mb-6">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">التلعيب والتحديات</h3>
                    <p class="text-gray-300">نظام نقاط وشارات وتحديات لتحفيز الطلاب على الاستمرار وتحسين مهاراتهم.</p>
                </div>

                <!-- Feature 6 -->
                <div class="glass-card glass-card-hover p-8 rounded-xl">
                    <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mb-6">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">الذكاء الاصطناعي</h3>
                    <p class="text-gray-300">مساعد ذكي للإجابة على الأسئلة السريعة وتقديم إرشادات فورية للمشاريع.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Technology Widgets Section -->
    <section class="relative z-10 py-20 px-4 sm:px-6 lg:px-8 bg-gray-900/50">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-6">
                    <span class="text-white">تقنيات متطورة</span>
                    <span class="text-orange-500"> لتعزيز التعلم</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    اكتشف كيف تستخدم منصة تدريب أحدث التقنيات لتوفير تجربة تعلم فريدة ومتطورة
                </p>
            </div>

            <!-- Widgets Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
                <!-- GitHub Integration Widget -->
                <div class="glass-card p-8 rounded-xl">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mr-4">
                            <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white">تكامل GitHub المتقدم</h3>
                    </div>
                    <div class="bg-gray-800 rounded-lg p-4 mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-400">مستودع المشروع</span>
                            <span class="text-xs text-orange-500">مُحدث الآن</span>
                        </div>
                        <div class="text-sm text-gray-300 font-mono">
                            <div class="flex items-center">
                                <span class="text-orange-500 mr-2">●</span>
                                <span>tadreeb-project-ecommerce</span>
                            </div>
                            <div class="text-gray-500 mt-1">
                                آخر تحديث: منذ 5 دقائق
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm">
                        إنشاء مستودعات تلقائية، متابعة التقدم، وإدارة المشاريع مباشرة من GitHub
                    </p>
                </div>

                <!-- AI Assistant Widget -->
                <div class="glass-card p-8 rounded-xl">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mr-4">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white">مساعد الذكاء الاصطناعي</h3>
                    </div>
                    <div class="bg-gray-800 rounded-lg p-4 mb-4">
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white text-sm font-bold">AI</span>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm text-gray-300 mb-1">
                                    كيف يمكنني تحسين أداء قاعدة البيانات؟
                                </div>
                                <div class="text-xs text-gray-500">
                                    جاري الإجابة...
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm">
                        إجابات فورية لأسئلة البرمجة، نصائح تحسين الكود، وإرشادات تقنية متخصصة
                    </p>
                </div>
            </div>


        </div>
    </section>


    <!-- Pricing Section -->
    <section id="pricing" class="relative z-10 py-20 px-4 sm:px-6 lg:px-8 bg-gray-800/50">
        <div class="max-w-7xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-6">
                    <span class="text-white">خطط الاشتراك</span>
                    <span class="text-orange-500"> في منصة تدريب</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto mb-8">
                    اختر الخطة المناسبة لك وابدأ رحلتك نحو اكتساب الخبرة العملية الحقيقية
                </p>

                <!-- Pricing Toggle -->
                <div class="inline-flex items-center bg-gray-700 rounded-lg p-1">
                    <button
                        class="px-6 py-2 text-sm font-medium text-orange-500 bg-gray-800 rounded-md transition-all duration-200">
                        سنوي (وفر 20%)
                    </button>
                    <button
                        class="px-6 py-2 text-sm font-medium text-gray-400 hover:text-white transition-colors duration-200">
                        شهري
                    </button>
                </div>
            </div>

            <!-- Pricing Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Student Plan -->
                <div class="glass-card glass-card-hover p-8 rounded-xl">
                    <h3 class="text-2xl font-bold text-white mb-2">الطالب</h3>
                    <p class="text-gray-400 mb-6">مثالي للطلاب الجامعيين والمبتدئين</p>
                    <div class="mb-8">
                        <span class="text-5xl font-bold text-white">400</span>
                        <span class="text-gray-400"> جنيه/شهر</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">5 مشاريع شهرياً</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">إرشاد أساسي</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">تكامل GitHub</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">مساعد AI أساسي</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">نسبة 70% من مبيعات السوق</span>
                        </li>
                    </ul>
                    <button
                        class="w-full py-3 px-6 border border-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        ابدأ كطالب
                    </button>
                </div>

                <!-- Mentor Plan -->
                <div class="glass-card glass-card-hover p-8 rounded-xl border-2 border-orange-500 relative">
                    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                        <span class="bg-orange-500 text-white px-4 py-1 rounded-full text-sm font-medium">الأكثر
                            شعبية</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">المرشد</h3>
                    <p class="text-gray-400 mb-6">للخبراء والمطورين المتقدمين</p>
                    <div class="mb-8">
                        <span class="text-5xl font-bold text-white">800</span>
                        <span class="text-gray-400"> جنيه/شهر</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">مشاريع غير محدودة</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">إرشاد متقدم + مراجعة مشاريع</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">دخل إضافي من الإرشاد</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">مساعد AI متقدم</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">نسبة 80% من مبيعات السوق</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">دعم أولوية</span>
                        </li>
                    </ul>
                    <button
                        class="w-full py-3 px-6 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors duration-200">
                        ابدأ كمرشد
                    </button>
                </div>

                <!-- University Plan -->
                <div class="glass-card glass-card-hover p-8 rounded-xl">
                    <h3 class="text-2xl font-bold text-white mb-2">الجامعة</h3>
                    <p class="text-gray-400 mb-6">للجامعات والشركات الكبيرة</p>
                    <div class="mb-8">
                        <span class="text-5xl font-bold text-white">3000</span>
                        <span class="text-gray-400"> جنيه/سنة</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">طلاب غير محدودين</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">مشاريع مخصصة للجامعة</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">تقارير تفصيلية للتقدم</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">دعم مخصص 24/7</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">تكامل مع أنظمة الجامعة</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">شهادات معتمدة</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-5 w-5 text-orange-500 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-300">تدريب أعضاء هيئة التدريس</span>
                        </li>
                    </ul>
                    <button
                        class="w-full py-3 px-6 border border-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        تواصل معنا
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative z-10 py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-5xl font-bold mb-8">
                <span class="text-white">ابدأ رحلتك نحو</span>
                <br>
                <span class="text-orange-500">الخبرة العملية الحقيقية</span>
            </h2>
            <p class="text-xl text-gray-300 mb-12">
                انضم إلى آلاف الطلاب العرب الذين اكتسبوا خبرة عملية حقيقية من خلال مشاريع واقعية وإرشاد متخصص
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#pricing"
                    class="inline-flex items-center px-8 py-4 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg text-lg transition-all duration-300 transform hover:scale-105">
                    ابدأ مجاناً الآن
                </a>
                <a href="#contact"
                    class="inline-flex items-center px-8 py-4 border-2 border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white font-semibold rounded-lg text-lg transition-all duration-300">
                    تواصل معنا
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative z-10 bg-gray-800/50 border-t border-gray-700 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo and Description -->
                <div class="col-span-1 md:col-span-2">
                    <div class="mb-4">
                        <img src="{{ asset('assets/images/logo/full-dark.png') }}" alt="TADREEB Logo"
                            class="h-12 w-auto">
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">
                        منصة التدريب التقني المتطورة التي تساعد الشركات على النمو والنجاح من خلال حلول تدريبية مبتكرة.
                    </p>
                    <div class="flex space-x-4 space-x-reverse">
                        <a href="#" class="text-gray-400 hover:text-orange-500 transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-orange-500 transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-orange-500 transition-colors">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">روابط سريعة</h3>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-gray-400 hover:text-white transition-colors">المميزات</a>
                        </li>
                        <li><a href="#pricing" class="text-gray-400 hover:text-white transition-colors">الأسعار</a>
                        </li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors">تواصل معنا</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">المدونة</a>
                        </li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">الدعم</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">مركز
                                المساعدة</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">الوثائق</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">API</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">الحالة</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; 2024 منصة تدريب TADREEB. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/index.js') }}"></script>
    <script defer src="{{ asset('assets/js/bundle.js') }}"></script>
</body>

</html>
