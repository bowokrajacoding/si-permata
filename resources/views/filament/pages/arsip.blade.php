<x-filament::page>
    <h2 class="text-lg font-bold mb-4">Daftar Arsip Surat</h2>
    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-3 py-2">Tipe</th>
                <th class="border px-3 py-2">Nomor</th>
                <th class="border px-3 py-2">Perihal</th>
                <th class="border px-3 py-2">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($this->surats as $surat)
                <tr>
                    <td class="border px-3 py-2">{{ $surat['tipe'] }}</td>
                    <td class="border px-3 py-2">{{ $surat['nomor'] }}</td>
                    <td class="border px-3 py-2">{{ $surat['perihal'] }}</td>
                    <td class="border px-3 py-2">{{ \Carbon\Carbon::parse($surat['tanggal'])->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-filament::page>
