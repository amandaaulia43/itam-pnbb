@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h3 class="text-xl font-bold text-gray-800">Manajemen Ruangan</h3>
            <p class="text-sm text-gray-500 mt-1">Kelola daftar ruangan inventaris pada Pengadilan Negeri Bale Bandung</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
            <i class="bi bi-check-circle-fill text-xl text-emerald-500"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
            <i class="bi bi-exclamation-triangle-fill text-xl text-red-500"></i>
            <span class="text-sm font-medium">{{ $errors->first() }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
            <h4 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="bi bi-plus-circle-fill text-[#0f4c3a]"></i> Tambah Ruangan Baru
            </h4>
            <form action="{{ route('locations.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Ruangan</label>
                    <input type="text" name="name" required placeholder="Contoh: Ruang Sidang Utama" 
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#0f4c3a]/20 focus:border-[#0f4c3a] transition-all text-sm bg-gray-50/50 focus:bg-white">
                </div>
                <button type="submit" class="w-full bg-[#0f4c3a] hover:bg-[#0d4031] text-white font-medium py-2.5 px-4 rounded-xl shadow-md transition-all text-sm flex items-center justify-center gap-2">
                    <i class="bi bi-save"></i> Simpan Ruangan
                </button>
            </form>
        </div>

        <div class="lg:grid-cols-1 lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h4 class="text-base font-bold text-gray-800">Daftar Ruangan Aktif</h4>
                <span class="text-xs bg-emerald-50 text-emerald-700 font-bold px-2.5 py-1 rounded-full border border-emerald-100">
                    Total: {{ $locations->count() }} Ruangan
                </span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/30">
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider w-16 text-center">No</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider">Nama Ruangan</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-gray-400 uppercase tracking-wider w-32 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($locations as $index => $room)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-gray-500 text-center">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $room->name }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openEditModal({{ $room->id }}, '{{ $room->name }}')" 
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-amber-600 hover:bg-amber-50 border border-transparent hover:border-amber-200 transition-all" title="Ubah Nama">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        
                                        <form action="{{ route('locations.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?');" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 border border-transparent hover:border-red-200 transition-all" title="Hapus Ruangan">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-sm text-gray-400 font-medium">
                                    <i class="bi bi-door-closed text-3xl block mb-2 opacity-50"></i> Belum ada data ruangan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-gray-900/50 z-50 hidden flex items-center justify-center backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 max-w-md w-full overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="modalBox">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h4 class="font-bold text-gray-800 flex items-center gap-2"><i class="bi bi-pencil-square text-amber-500"></i> Ubah Nama Ruangan</h4>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600"><i class="bi bi-x-lg"></i></button>
        </div>
        <form id="editForm" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Ruangan Baru</label>
                <input type="text" id="editNameInput" name="name" required 
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all text-sm">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 text-sm font-medium transition-all">Batal</button>
                <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-medium shadow-md transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, currentName) {
        const modal = document.getElementById('editModal');
        const modalBox = document.getElementById('modalBox');
        const form = document.getElementById('editForm');
        const input = document.getElementById('editNameInput');

        // Set action form dinamis ke route update Laravel
        form.action = `/locations/${id}`;
        input.value = currentName;

        // Tampilkan modal dengan efek transisi halus
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalBox.classList.remove('scale-95', 'opacity-0');
            modalBox.classList.add('scale-100', 'opacity-100');
        }, 50);
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        const modalBox = document.getElementById('modalBox');

        modalBox.classList.remove('scale-100', 'opacity-100');
        modalBox.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection