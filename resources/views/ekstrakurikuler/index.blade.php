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
        const csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/ekstrakurikuler/ekstrakurikuler.js') }}"></script>
</X-layout.main>