<div>
    <x-slot name="header">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
            {{ isset($kegiatanId) ? 'Edit Kegiatan' : 'Tambah Kegiatan' }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Flash Message --}}
        @if (session()->has('message'))
            <div class="mb-6 p-4 rounded-md bg-green-100 border border-green-300 text-green-800">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">
            <form wire:submit="save" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul</label>
                    <input type="text" wire:model.defer="judul"
                        class="mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500" />
                    @error('judul') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                    <textarea wire:model.defer="deskripsi" rows="4"
                        class="mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500"></textarea>
                    @error('deskripsi') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kuota</label>
                    <input type="number" wire:model.defer="kuota"
                        class="mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500" />
                    @error('kuota') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ url()->previous() }}"
                       class="inline-flex items-center px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium transition mr-2">
                        ← Kembali
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition shadow">
                        {{ isset($kegiatanId) ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

