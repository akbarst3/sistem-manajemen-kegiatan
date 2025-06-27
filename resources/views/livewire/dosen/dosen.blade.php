<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Kegiatan Yang Perlu Persetujuan</h1>

    @if (session()->has('message'))
        <div class="mb-6 p-4 rounded-md bg-green-100 border border-green-300 text-green-800">
            {{ session('message') }}
        </div>
    @endif

    @if ($kegiatans->count() === 0)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-6 rounded-md shadow">
            <p class="font-semibold text-lg mb-1">Tidak ada kegiatan yang perlu ditinjau.</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
            <table class="w-full table-auto divide-y divide-gray-200 dark:divide-gray-700 text-sm text-gray-900 dark:text-gray-100">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-semibold uppercase">
                    <tr>
                        <th class="px-6 py-4 text-left">Judul</th>
                        <th class="px-6 py-4 text-left">Deskripsi</th>
                        <th class="px-6 py-4 text-left">Kuota</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 text-base">
                    @foreach ($kegiatans as $kegiatan)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                            <td class="px-6 py-4 font-medium">{{ $kegiatan->judul }}</td>
                            <td class="px-6 py-4">{{ $kegiatan->deskripsi }}</td>
                            <td class="px-6 py-4">{{ $kegiatan->kuota }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-3">
                                    <button wire:click="approve('{{ $kegiatan->id }}')"
                                            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md text-xs font-medium transition">
                                        ✅ Approve
                                    </button>
                                    <button wire:click="unapprove('{{ $kegiatan->id }}')"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs font-medium transition">
                                        ❌ Tolak
                                    </button>
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
</div>

