@extends('layouts.user')

@section('content')
    <div class="bg-pink-50 shadow p-6 max-w-6xl mx-auto mt-10 rounded-lg">
        <h1 class="text-2xl font-bold text-pink-800 mb-4">Selamat Datang, {{ auth()->user()->name }}</h1>
        <p class="text-pink-600 mb-6">Lihat dan beli produk yang tersedia di bawah ini.</p>

        <div class="flex flex-wrap gap-3 mb-6">
            <a href="{{ route('user.cart') }}" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
                🛒 Lihat Keranjang
            </a>
            <a href="{{ route('user.transactions') }}" class="bg-pink-400 text-white px-4 py-2 rounded hover:bg-pink-500">
                📦 Riwayat Transaksi
            </a>
            <a href="{{ route('user.chat') }}" class="bg-pink-300 text-white px-4 py-2 rounded hover:bg-pink-400">
                💬 Chat dengan Admin
            </a>
        </div>

        <form method="GET" action="{{ route('user.dashboard') }}" class="mb-6 flex flex-col sm:flex-row gap-4">
            <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                class="border border-pink-300 p-2 rounded w-full sm:w-1/2 focus:outline-pink-400">

            <select name="kategori" class="border border-pink-300 p-2 rounded w-full sm:w-1/4">
                <option value="">Semua Kategori</option>
                @foreach ($kategori as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">Filter</button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse ($produk as $item)
                <div class="border border-pink-200 rounded p-4 shadow bg-white flex flex-col justify-between">
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                        class="w-full h-40 object-cover rounded mb-2">
                    <h2 class="text-lg font-semibold text-pink-700">{{ $item->nama }}</h2>
                    <p class="text-sm text-pink-500">{{ $item->kategori->nama }}</p>
                    <p class="mt-1 text-pink-800 font-bold">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>

                    <form action="{{ route('user.cart.add', $item->id) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600 w-full">
                            Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            @empty
                <p class="col-span-full text-pink-600">Produk tidak ditemukan.</p>
            @endforelse
        </div>
    </div>
@endsection