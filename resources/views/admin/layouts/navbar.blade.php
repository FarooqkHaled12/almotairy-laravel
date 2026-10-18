<!-- Top Navigation Bar -->
<header class="bg-white shadow-sm flex-shrink-0">
    <div class="flex items-center justify-between h-16 px-4 md:px-6">
        <div class="flex items-center">
            <!-- Mobile Sidebar Toggle -->
            <button @click="sidebarOpen = true" class="p-2 mr-2 text-gray-600 lg:hidden focus:outline-none focus:bg-gray-100 rounded-lg">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <h1 class="text-lg md:text-2xl font-bold text-gray-800">@yield('page-title', 'لوحة التحكم')</h1>
        </div>
        <div class="flex items-center space-x-4 space-x-reverse">
            <!-- الوقت والتاريخ (يختفي في الشاشات الصغيرة جداً) -->
            <div class="hidden sm:block text-left">
                <p class="text-sm font-semibold text-gray-700" id="current-time"></p>
                <p class="text-xs text-gray-500" id="current-date"></p>
            </div>
        </div>
    </div>
</header>

<script>
    function updateDateTime() {
        const now = new Date();
        
        // التاريخ
        const dateOptions = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };
        document.getElementById('current-date').textContent = now.toLocaleDateString('ar-EG', dateOptions);
        
        // الوقت
        const timeOptions = { 
            hour: '2-digit', 
            minute: '2-digit',
            second: '2-digit'
        };
        document.getElementById('current-time').textContent = now.toLocaleTimeString('ar-EG', timeOptions);
    }
    
    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>
