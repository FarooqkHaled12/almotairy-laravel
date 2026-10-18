<!-- Sidebar Mobile Overlay -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false" 
     x-cloak
     class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity lg:hidden">
</div>

<!-- Sidebar -->
<aside :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'" 
       class="fixed inset-y-0 right-0 z-30 w-64 transition duration-300 transform bg-gradient-to-b from-purple-700 to-indigo-800 lg:translate-x-0 lg:static lg:inset-0 text-white flex-shrink-0">
    <div class="flex flex-col h-full overflow-hidden">
        <!-- Logo -->
        <div class="flex items-center justify-center h-20 border-b border-purple-600 flex-shrink-0 relative">
            <!-- Close Button for Mobile -->
            <button @click="sidebarOpen = false" class="lg:hidden absolute left-4 text-white focus:outline-none">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="flex items-center space-x-3 space-x-reverse">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold">المطيري</span>
            </div>
        </div>

        <!-- Navigation Scrollable Section -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto custom-scrollbar">
            <!-- الرئيسية -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
                <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="font-semibold">الرئيسية</span>
            </a>

            <a href="{{ route('admin.hero.edit') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.hero.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
                <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="font-semibold">قسم الهيرو</span>
            </a>

            <a href="{{ route('admin.about.edit') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.about.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
                <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-2.21 0-4 1.79-4 4v4h8v-4c0-2.21-1.79-4-4-4zM4 20h16M4 16h16"></path>
                </svg>
                <span class="font-semibold">قسم من أنا</span>
            </a>

            <a href="{{ route('admin.services.edit') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.services.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
                <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m-6-8h6M4 6h16M4 18h16" />
                </svg>
                <span class="font-semibold">الخدمات</span>
            </a>

            <a href="{{ route('admin.faq.index') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.faq.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
                <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 9h8m-8 4h6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                </svg>
                <span class="font-semibold">الأسئلة الشائعة</span>
            </a>

            <a href="{{ route('admin.contact.edit') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.contact.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
                <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M22 2H2v20h20V2zM5 6h14M5 10h14M5 14h14M5 18h7" />
                </svg>
                <span class="font-semibold">بيانات التواصل</span>
            </a>

            <a href="{{ route('admin.story.edit') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.story.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
                <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 20l9-5-9-5-9 5 9 5zm0-10l9-5-9-5-9 5 9 5z" />
                </svg>
                <span class="font-semibold">قصتنا</span>
            </a>

            <a href="{{ route('admin.values.index') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.values.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
                <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.1 0-2 .9-2 2v8a2 2 0 002 2h6a2 2 0 002-2V10a2 2 0 00-2-2h-6zM6 10v10M6 4h.01" />
                </svg>
                <span class="font-semibold">القيم</span>
            </a>

            <a href="{{ route('admin.statistics.edit') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.statistics.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
                <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 3v18m6-6a9 9 0 11-12 0 9 9 0 0112 0z" />
                </svg>
                <span class="font-semibold">الإحصائيات</span>
            </a>

<a href="{{ route('admin.why.edit') }}"
   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.why.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
    <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12h6m-6 4h6M4 6h16M4 18h16" />
    </svg>
    <span class="font-semibold">لماذا تختارنا</span>
</a>

<a href="{{ route('admin.cta.edit') }}"
   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.cta.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
    <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 9h8m-8 4h6m-2 4h2M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
    </svg>
    <span class="font-semibold">قسم CTA</span>
</a>

<a href="{{ route('admin.consultations.edit') }}"
   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.consultations.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
   <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
             d="M9 12h6m-6 4h6M4 6h16M4 18h16" />
   </svg>
   <span class="font-semibold">الاستشارات</span>
</a>

<a href="{{ route('admin.contact2.edit') }}"
   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.contact2.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
    <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M22 2H2v20h20V2zM5 6h14M5 10h14M5 14h14M5 18h7" />
    </svg>
    <span class="font-semibold">الاتصال 2</span>
</a>

<a href="{{ route('admin.map.edit') }}"
   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.map.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
    <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17.657 16.657L13.414 12.414a4 4 0 10-5.657 5.657L12 21l5.657-4.343z" />
    </svg>
    <span class="font-semibold">الخريطة</span>
</a>

<a href="{{ route('admin.categories.index') }}"
   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
    <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 7h18M3 12h18M3 17h18" />
    </svg>
    <span class="font-semibold">تصنيفات العقارات</span>
</a>

<a href="{{ route('admin.properties.index') }}"
   class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.properties.*') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
    <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 10h16M4 14h10M4 18h10" />
    </svg>
    <span class="font-semibold">العقارات</span>
</a>
















            <!-- Divider -->
            <div class="border-t border-purple-600 my-2"></div>

            <a href="{{ route('admin.password.edit') }}"
               class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.password.edit') ? 'bg-white text-purple-700 shadow-lg' : 'hover:bg-purple-600' }}">
                <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
                <span class="font-semibold">تغيير كلمة المرور</span>
            </a>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center px-4 py-3 rounded-lg transition-all duration-200 hover:bg-red-600 text-right">
                    <svg class="w-6 h-6 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span class="font-semibold">تسجيل الخروج</span>
                </button>
            </form>
        </nav>

        <!-- Footer -->
        <div class="flex-shrink-0 px-4 py-4 border-t border-purple-600">
            <div class="flex items-center space-x-3 space-x-reverse">
                <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center">
                    <span class="text-sm font-bold">{{ substr(Auth::guard('admin')->user()->name, 0, 2) }}</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold">{{ Auth::guard('admin')->user()->name }}</p>
                    <p class="text-xs text-purple-300">مسؤول النظام</p>
                </div>
            </div>
        </div>
    </div>
</aside>

<style>
/* تخصيص التمرير */
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.4);
    border-radius: 6px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: rgba(255, 255, 255, 0.65);
}
</style>
