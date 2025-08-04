<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700" rel="stylesheet" />

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Vite (if applicable) -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen font-sans antialiased">
    <div id="app">
        <!-- Navbar -->
        <!-- Navbar -->
        <nav class="bg-black fixed w-full z-50 shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <a href="{{ url('/admin/dashboard') }}" class="text-white font-bold text-lg">
                       ADR BOOKS ( {{ Auth::user()->name }} )
                    </a>
        
                    <!-- Logout Button -->
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="text-white font-semibold hover:text-gray-300">
                        Logout
                    </a>
                </div>
            </div>
        </nav>
        
        <!-- Hidden logout form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>


        <!-- Hidden logout form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>

        <!-- Page Content -->
        <main class="pt-14">
            @yield('content')
        </main>
    </div>

    <!-- Dropdown toggle script -->
    <script>
        function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            menu.classList.toggle('hidden');
        }

        // Optional: Close dropdown when clicking outside
        window.addEventListener('click', function (e) {
            const btn = document.getElementById('dropdownButton');
            const menu = document.getElementById('dropdownMenu');
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>

</html>