<?php

use App\Models\DaftarKegiatan;
use Illuminate\Support\Str;

?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"> 
    {{-- Tombol Toggle --}}
    <div class="flex justify-end gap-2 mb-6">
        <button wire:click="toggleView('table')"
                class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium transition 
                {{ $viewType === 'table' ? 'bg-blue-600 text-white shadow' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
            🧾 Tabel
        </button>
        <button wire:click="toggleView('card')"
                class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium transition 
                {{ $viewType === 'card' ? 'bg-blue-600 text-white shadow' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
            🗂️ Kartu
        </button>
    </div>

    {{-- Header dan Tambah --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Daftar Kegiatan {{ auth()->user()->name;}}</h1>
        <a href="{{ route('himpunan.kegiatan.create') }}" 
           class="inline-flex items-center px-5 py-3 rounded-md bg-green-600 hover:bg-green-700 text-white text-sm font-semibold transition shadow">
            ➕ Tambah Kegiatan
        </a>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="mb-6 p-4 rounded-md bg-green-100 border border-green-300 text-green-800">
            {{ session('message') }}
        </div>
    @endif

    {{-- Cek Kosong --}}
    @if ($kegiatans->total() === 0)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-6 rounded-md shadow">
            <p class="font-semibold text-lg mb-1">Belum ada kegiatan!</p>
            <p>Tambahkan kegiatan untuk memulai.</p>
        </div>
    @else
        {{-- TABEL --}}
        @if ($viewType === 'table')
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                <table class="w-full table-auto divide-y divide-gray-200 dark:divide-gray-700 text-sm text-gray-900 dark:text-gray-100">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-semibold uppercase">
                        <tr>
                            <th class="px-6 py-4 text-left">Judul</th>
                            <th class="px-6 py-4 text-left">Deskripsi</th>
                            <th class="px-6 py-4 text-left">Kuota</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-base">
                        @foreach ($kegiatans as $kegiatan)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                                <td class="px-6 py-4 font-medium">{{ $kegiatan->judul }}</td>
                                <td class="px-6 py-4">{{ $kegiatan->deskripsi }}</td>
                                <td class="px-6 py-4">{{ $kegiatan->kuota }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($kegiatan->status === 'approved') bg-green-100 text-green-800
                                        @elseif($kegiatan->status === 'submitted') bg-gray-100 text-gray-800
                                        @elseif($kegiatan->status === 'under_review') bg-yellow-100 text-yellow-800
                                        @elseif($kegiatan->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ Str::ucfirst($kegiatan->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-3">
                                        @if (!in_array($kegiatan->status, ['approved', 'rejected']))
                                            <a href="{{ route('himpunan.kegiatan.edit', $kegiatan) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                                ✏️
                                            </a>
                                            <button wire:click="delete('{{ $kegiatan->id }}')"
                                                onclick="confirm('Apakah Anda yakin ingin menghapus kegiatan ini?') || event.stopImmediatePropagation()"
                                                class="text-red-600 hover:text-red-800 text-sm">
                                                🗑️
                                            </button>
                                        @else
                                            <span class="text-gray-500 text-sm italic">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6 flex justify-center">
                {{ $kegiatans->links() }}
            </div>
        @endif

        {{-- KARTU --}}
        @if ($viewType === 'card')
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($kegiatans as $kegiatan)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 flex flex-col">
                        <div class="p-6 flex-grow">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $kegiatan->judul }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-3 mb-4">{{ $kegiatan->deskripsi }}</p>
                            <div class="flex justify-between items-center text-sm text-gray-700 dark:text-gray-300">
                                <span>Kuota: <span class="text-blue-600">{{ $kegiatan->kuota }}</span></span>
                                <span class="px-3 py-1 text-xs font-medium rounded-full 
                                    @if($kegiatan->status === 'approved') bg-green-100 text-green-800
                                    @elseif($kegiatan->status === 'submitted') bg-gray-100 text-gray-800
                                    @elseif($kegiatan->status === 'under_review') bg-yellow-100 text-yellow-800
                                    @elseif($kegiatan->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ Str::ucfirst($kegiatan->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 bg-gray-50 dark:bg-gray-700 p-4 border-t border-gray-200 dark:border-gray-600">
                            @if (!in_array($kegiatan->status, ['approved', 'rejected']))
                                <a href="{{ route('himpunan.kegiatan.edit', $kegiatan) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-xs font-medium transition">Edit</a>
                                <button wire:click="delete('{{ $kegiatan->id }}')"
                                    onclick="confirm('Apakah Anda yakin ingin menghapus kegiatan ini?') || event.stopImmediatePropagation()"
                                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs font-medium transition">Hapus</button>
                            @else
                                <span class="text-gray-500 text-sm italic">-</span>
                            @endif            
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 flex justify-center">
                {{ $kegiatans->links() }}
            </div>
        @endif
    @endif
</div>

