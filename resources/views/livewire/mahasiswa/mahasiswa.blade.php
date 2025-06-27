<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Kegiatan Tersedia</h1>

    @if (session()->has('message'))
        <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-300">
            {{ session('message') }}
        </div>
    @endif

    @if ($kegiatans->isEmpty())
        <div class="p-6 bg-yellow-100 text-yellow-800 rounded border border-yellow-300">
            Tidak ada kegiatan yang tersedia untuk didaftar.
        </div>
    @else
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow border border-gray-200 dark:border-gray-700">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-gray-900 dark:text-gray-100">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold uppercase">
                    <tr>
                        <th class="px-6 py-4 text-left">Judul</th>
                        <th class="px-6 py-4 text-left">Deskripsi</th>
                        <th class="px-6 py-4 text-left">Kuota</th>
                        <th class="px-6 py-4 text-left">Penyelenggara</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($kegiatans as $kegiatan)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $kegiatan->judul }}</td>
                            <td class="px-6 py-4">{{ $kegiatan->deskripsi }}</td>
                            <td class="px-6 py-4">
                                {{ $kegiatan->peserta_count }} / {{ $kegiatan->kuota }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $kegiatan->pembuat->name === 'Admin' ? 'Kampus' : $kegiatan->pembuat->name }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button wire:click="daftar('{{ $kegiatan->id }}')"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm font-semibold">
                                    Daftar
                                </button>
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

