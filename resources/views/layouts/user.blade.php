<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - User</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700" rel="stylesheet" />

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
<body class="bg-[#1e1e28d9] font-sans antialiased">
    <div id="app">
        <!-- Navbar -->
        <nav class="bg-black fixed w-full z-50 shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ url('/user/dashboard') }}" class="text-white font-bold text-lg">
                        AzurBook Store ( {{ Auth::user()->name }} )
                        </a>
                    </div>

                    <div class="flex items-center space-x-6">
                        <a href="https://myportfolioadrian.vercel.app"class="flex items-center px-4 py-2 bg-black text-white border-2 border-white font-semibold rounded-lg hover:bg-blue-600 hover:border-blue-600 transform hover:scale-105 transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                            About Us
                        </a>

                        <!-- Tombol Logout -->
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="flex items-center px-4 py-2 bg-black text-white border-2 border-white font-semibold rounded-lg hover:bg-red-600 hover:border-red-600 transform hover:scale-105 transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>

        <!-- Content -->
        <main class="pt-20">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>