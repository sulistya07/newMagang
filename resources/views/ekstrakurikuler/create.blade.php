<X-layout.main>
    <section class="=max-w-7xl mx-auto px-6 py-10">
        <h1 class="=text-3xl font-bold text-indigo-700 mb-6">Daftar Ekstrakurikuler</h1>

        {{--Tombol Tambah & Search --}}
        <div class="=flex items-center justify-between mb4 gap-4">
            <a href="{{ route('ekstrakurikuler.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                + Tambah Ekstrakurikuler
            </a>
            <div class="flex items-centre gap-2">
                <input type="text" id="searchInput" placeholder="Cari nama Ekstrakurikuler..."
                class="px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-indigo-300">
                <button id="clearSearchBtn" class="ml-2 px-3 py-2 border rounded hover:bg-gray-100">Reset</button>
            </div>
        </div>
        <!-- Notifikasi -->
        <div id="notification" class="hidden"></div>
        <!-- Modal Konfirmasi Hapus -->
        <div id="deleteModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded-lg shadow-lg w-96">
                <div class="p-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-700">Konfirmasi</h2>
                </div>
                <div class="p-4">
                    <p id="deleteMessage" class="text-gray-600">Apakah Anda yakin ingin menghapus data ini?</p>
                </div>
                <div class="flex justify-end gap-2 p-4 border-t">
                    <button onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                <button id="confirmDeleteBtn"
                class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Ya, Hapus</button>
            
                </div>
            </div>
        </div>
        {{-- Tabel Data --}}
        <div class="bg-white shadow rounded-lg over-hidden">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-indigo-100 text-left">
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Nama Ekstrakurikuler</th>
                        <th class="px-4 py-2 border">Pembina</th>
                        <th class="px-4 py-2 border">Jadwal</th>
                        <th class="px-4 py-2 border">Kuota</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="ekskulTable">
                    <tr>
                        <td colspan="6" class="text-center py-4">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="flex justify-between items-center mt-4 gap-4" id="pagination"></div>
    </section>
    <script>
        const csrfToken = "{{ csrf_token() }}"
    </script>
    <script src="{{ asset('js/ekstrakurikuler/ekstrakurikuler.js') }}"></script>
</X-layout.main>


<X-layout.main>
    <section class="max-w-3xl mx-auto px-6 py-10">
        <h1 class="text-2xl font-bold text-indigo-700 mb-6">Tambah Ekstrakurikuler</h1>
        <!-- Notifikasi -->
        <div id="notification" clas="hidden"></div>
        <form id="createForm" class="space-y-4 bg-white shadow-md rounded-lg p-6">
            @csrf
            <div>
                <label class="block text-sm font-medium">Nama Ekstrakurikuler</label>
                <input type="text" name="nama_ekskul" required
                    class="w-full border rounded px-3 py-2 mt-1 focus:ring focus: ring-indigo-200">
            </div>
            <div>
                <label class="block text-sm font-medium">Pembina</label>
                <input type="text" name="pembina" required
                    class="w-full border rounded px-3 py-2 mt-1 focus:ring focus: ring-indigo-200">
            </div>
            <div>
                <label class="block text-sm font-medium">Jadwal</label>
                <input type="text" name="jadwal"
                    class="w-full border rounded px-3 py-2 mt-1 focus:ring focus: ring-indigo-200">
            </div>
            <div>
                <label class="block text-sm font-medium">Kuota</label>
                <input type="text" name="kuota"
                    class="w-full border rounded px-3 py-2 mt-1 focus:ring focus: ring-indigo-200">
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('ekstrakurikuler.index') }}"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-indigi-600 text-white rounded hover:bg-indigo-700">
                    Simpan
                </button>
            </div>
        </form>
    </section>
{{-- load file js --}}
<script src="{{ asset('js/ekstrakurikuler/create.js') }}"></script>
<script>
    const csrfToken = "{{ csrf_token() }}";
</script>
</X-layout.main>

<x-layouts.main>
<div class= "p-4">
    <h2 class="text=xl font-bold mb-4">Edit Ekstrakurikuler</h2>
    <!-- Notifikasi -->
    <div id="notification" class="hidden"></div>

    <form id="editEkskulForm">
        <input type="hidden" id="id_ekskul">

        <div class="mb-2">
            <label class="block">Pembina</label>
            <input type="text" id="pembina" class="border p-2 w-full">
        </div>
        <div class="mb-2">
            <label class="block">Jadwal</label>
            <input type="text" id="jadwal" class="border p-2 w-full">
        </div>
        <div class="mb-2">
            <label class="block">Kuota</label>
            <input type="text" id="Kuota" class="border p-2 w-full">
        </div>
        <div class="flex gap-2 mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            <button type="button" onclick="window.location.href='/ekstrakurikuler'"
              class="bg-gray-400 text-white px-4 py-2 rounded">
              Batal 
        </button>
        </div>
    </form>
</div>
<script>
        const csrfToken = "{{ csrf_token() }}";
</script>
<script src="{{ asset('js/ekstrakurikuler/edit.js') }}"></script>
</x-layouts.main>