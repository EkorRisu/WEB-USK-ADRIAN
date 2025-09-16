@extends('layouts.user')

@section('content')
<div class="bg-[#1e1e28d9] shadow p-6 max-w-6xl mx-auto mt-10 rounded-lg">
    <h1 class="text-2xl font-bold text-white mb-4">Welcome {{ auth()->user()->name }}</h1>
    <p class="text-white mb-6">Lihat dan beli produk yang tersedia di bawah ini.</p>

    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('user.cart') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-800">
            🛒 Keranjang
        </a>
        <a href="{{ route('user.transactions') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-800">
            📦 Transaksi
        </a>
        <a href="{{ route('user.chat') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-800">
            💬 Chat Admin
        </a>
    </div>

    <form method="GET" action="{{ route('user.dashboard') }}" class="mb-6 flex flex-col sm:flex-row gap-4">
        <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
            class="border border-gray-800 p-2 rounded w-full sm:w-1/2 focus:outline-pink-400">

        <select name="kategori" class="border border-gray-800 p-2 rounded w-full sm:w-1/4">
            <option value="">Semua Kategori</option>
            @foreach ($kategori as $kat)
                <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                    {{ $kat->nama }}
                </option>
            @endforeach
        </select>

        <button type="submit"
            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-800 border-gray-500 border-md">
            Filter
        </button>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse ($produk as $item)
            <div class="border border-black rounded p-4 shadow bg-white flex flex-col justify-between">
                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                    class="w-full h-40 object-cover rounded mb-2">
                <h2 class="text-lg font-semibold text-black">{{ $item->nama }}</h2>
                <p class="text-sm text-gray-600">{{ $item->kategori->nama }}</p>
                <p class="mt-1 text-gray-800 font-bold">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>

                <!-- Stock Info -->
                <div class="product-stock text-black mt-1">
                    <span class="number-label">Stock:</span>
                    <span class="number-value">{{ $item->stok }}</span>
                </div>

                <form action="{{ route('user.cart.add', $item->id) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" 
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-black w-full">
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
