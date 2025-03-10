<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NovaPlanner Admin - @yield('title', 'Dashboard')</title>
    
    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-gray-800 text-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="text-xl font-bold">NovaPlanner Admin</span>
                        </div>
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                Admin Dashboard
                            </a>
                            <a href="{{ route('admin.appointments.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.appointments.*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                                Afspraken
                            </a>
                            <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                                Account Dashboard
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                            Terug naar website
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Flash Messages (positioned on the right side) -->
        @if(session('success'))
            <div class="fixed top-20 right-4 z-50 max-w-sm">
                <div class="bg-white rounded-lg shadow-xl border border-gray-200 p-4 transform transition-all duration-300 ease-in-out" 
                     x-data="{ show: true }" 
                     x-show="show" 
                     x-transition:enter="translate-x-full opacity-0" 
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="translate-x-0 opacity-100" 
                     x-transition:leave-end="translate-x-full opacity-0"
                     x-init="setTimeout(() => show = false, 5000)">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-900">Succesvol!</p>
                                <button @click="show = false" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="fixed top-20 right-4 z-50 max-w-sm">
                <div class="bg-white rounded-lg shadow-xl border border-gray-200 p-4 transform transition-all duration-300 ease-in-out" 
                     x-data="{ show: true }" 
                     x-show="show" 
                     x-transition:enter="translate-x-full opacity-0" 
                     x-transition:enter-end="translate-x-0 opacity-100"
                     x-transition:leave="translate-x-0 opacity-100" 
                     x-transition:leave-end="translate-x-full opacity-0"
                     x-init="setTimeout(() => show = false, 5000)">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-900">Fout!</p>
                                <button @click="show = false" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <div class="flex-grow">
            <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                @yield('content')
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-white mt-auto border-t border-gray-200">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} NovaPlanner Admin
                </p>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html> 