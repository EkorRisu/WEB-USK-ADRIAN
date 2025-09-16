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

    <style>
        .hover-slide {
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .hover-slide::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: #000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            z-index: -1;
        }
        
        .hover-slide:hover::before {
            transform: translateX(0);
        }
        
        .hover-slide:hover {
            color: white;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen font-sans antialiased">
    <div id="app">
        <!-- Navbar -->
<nav class="bg-black fixed top-0 left-0 w-full z-50 shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="/" class="text-white font-bold text-lg">
                Azur BookStore  
            </a>

            <!-- Menu kanan -->
            @if (Route::has('login'))
                <div class="flex items-center space-x-4">
                    @auth
                        @php
                            $role = Auth::user()->role ?? 'user';
                        @endphp

                        @if ($role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="bg-gray-600 hover:bg-gray-800 text-white text-sm px-4 py-2 rounded transition">
                                Dashboard Admin
                            </a>
                        @elseif ($role === 'user')
                            <a href="{{ route('user.dashboard') }}"
                                class="bg-gray-600 hover:bg-gray-800 text-white text-sm px-4 py-2 rounded transition">
                                Dashboard User
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}"
                                class="bg-gray-600 hover:bg-gray-800 text-white text-sm px-4 py-2 rounded transition">
                                Dashboard
                            </a>
                        @endif
                    @else
                        <button id="loginButton"
                            class="border border-white text-white hover:border-white hover:bg-white hover:text-black text-sm px-4 py-2 rounded transition">
                            Log in
                        </button>

                        @if (Route::has('register'))
                            <button id="registerButton"
                            class="border border-white text-white hover:border-white hover:bg-white hover:text-black text-sm px-4 py-2 rounded transition">
                                Register
                            </button>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</nav>



        <!-- Hidden logout form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>

        <!-- Page Content -->
        <main>
            @yield('content')
            <!-- Modal Login -->
            <div id="loginModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
                <div class="bg-white p-6 rounded-lg w-full max-w-md relative">
                    <button id="closeLoginModal"
                        class="absolute top-2 right-3 text-gray-600 hover:text-red-500 text-2xl">&times;</button>
            
                    <h2 class="text-2xl font-bold mb-4 text-center">Login</h2>
            
                    @if(session('status'))
                        <div class="bg-green-100 text-green-800 p-2 rounded mb-3">{{ session('status') }}</div>
                    @endif
                    
                    @if(session('registration_success'))
                        <div class="bg-green-100 text-green-800 p-2 rounded mb-3">{{ session('registration_success') }}</div>
                    @endif
            
                    @if(session('error'))
                        <div class="bg-red-100 text-red-800 p-2 rounded mb-3">{{ session('error') }}</div>
                    @endif
            
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-800 p-2 rounded mb-3">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
            
                        <div class="mb-4">
                            <label for="email" class="block mb-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full border px-3 py-2 rounded">
                        </div>
            
                        <div class="mb-4">
                            <label for="password" class="block mb-1">Kata Sandi</label>
                            <input type="password" id="password" name="password" required class="w-full border px-3 py-2 rounded">
                        </div>
            
                        <button type="submit"
                            class="w-full  bg-black hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded">
                            Login
                        </button>
                    </form>
                </div>
            </div>

            <!-- Modal Register -->
            <div id="registerModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
                <div class="bg-white p-6 rounded-lg w-full max-w-md relative">
                    <button id="closeRegisterModal"
                        class="absolute top-2 right-3 text-gray-600 hover:text-red-500 text-2xl">&times;</button>
            
                    <h2 class="text-2xl font-bold mb-4 text-center">Registrasi</h2>
            
                    @if(session('success'))
                        <div class="bg-green-100 text-green-800 p-2 rounded mb-3">{{ session('success') }}</div>
                    @endif
            
                    @if ($errors->any() && request()->is('register'))
                        <div class="bg-red-100 text-red-800 p-2 rounded mb-3">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
            
                        <div class="mb-4">
                            <label for="name" class="block mb-1">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full border px-3 py-2 rounded">
                        </div>
            
                        <div class="mb-4">
                            <label for="email" class="block mb-1">Alamat Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full border px-3 py-2 rounded">
                        </div>
            
                        <div class="mb-4">
                            <label for="password" class="block mb-1">Kata Sandi</label>
                            <input type="password" id="password" name="password" required class="w-full border px-3 py-2 rounded">
                        </div>
            
                        <div class="mb-4">
                            <label for="password_confirmation" class="block mb-1">Konfirmasi Kata Sandi</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="w-full border px-3 py-2 rounded">
                        </div>
            
                        <button type="submit"
                            class="w-full  bg-black hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded">
                            Daftar
                        </button>
                    </form>
                </div>
            </div>

        </main>
    </div>

    @stack('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loginModal = document.getElementById('loginModal');
        const registerModal = document.getElementById('registerModal');

        document.getElementById('loginButton')?.addEventListener('click', () => {
            loginModal?.classList.remove('hidden');
        });

        document.getElementById('closeLoginModal')?.addEventListener('click', () => {
            loginModal?.classList.add('hidden');
        });

        document.getElementById('registerButton')?.addEventListener('click', () => {
            registerModal?.classList.remove('hidden');
        });

        document.getElementById('closeRegisterModal')?.addEventListener('click', () => {
            registerModal?.classList.add('hidden');
        });

        // Auto open modal if there are validation errors
        @if ($errors->any())
            @if (request()->is('register'))
                registerModal?.classList.remove('hidden');
            @else
                loginModal?.classList.remove('hidden');
            @endif
        @endif

        // Show login modal after successful registration
        @if(session('registration_success'))
            registerModal?.classList.add('hidden');
            loginModal?.classList.remove('hidden');
        @endif

        @if(session('error'))
            loginModal?.classList.remove('hidden');
        @endif
    });
</script>


</body>

</html>