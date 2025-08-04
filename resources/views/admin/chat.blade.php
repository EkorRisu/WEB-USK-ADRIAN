@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto mt-10 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="col-span-1 bg-white p-4 rounded shadow">
            <h2 class="text-lg font-bold mb-2">User</h2>
            <ul>
                @foreach ($users as $u)
                    <li class="mb-2">
                        <a href="{{ route('user.chat', ['user_id' => $u->id]) }}" class="text-blue-600 hover:underline">
                            {{ $u->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col-span-3 bg-white p-4 rounded shadow h-[500px] overflow-y-auto">
            @if ($selectedUser)
                <h2 class="text-xl font-bold mb-4">Chat dengan {{ $selectedUser->name }}</h2>

                <div class="space-y-2 mb-4">
                    @forelse ($messages as $msg)
                        <div class="{{ $msg->sender_id == auth()->id() ? 'text-right' : 'text-left' }}">
                            <div
                                class="inline-block px-4 py-2 rounded-lg {{ $msg->sender_id == auth()->id() ? 'bg-blue-100' : 'bg-gray-200' }}">
                                <p class="text-sm">{{ $msg->message }}</p>
                                <p class="text-xs text-gray-500">{{ $msg->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada pesan.</p>
                    @endforelse
                </div>

                <form action="{{ route('user.chat.store') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $selectedUser->id }}">
                    <input type="text" name="message" class="w-full border rounded p-2" placeholder="Ketik pesan...">
                    <button type="submit" class="bg-blue-500 text-white px-4 rounded">Kirim</button>
                </form>
            @else
                <p class="text-gray-500">Pilih user untuk memulai percakapan.</p>
            @endif
        </div>
    </div>
@endsection