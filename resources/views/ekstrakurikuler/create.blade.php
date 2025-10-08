<x-layouts.main>
    <section class="max-w-3xl mx-auto px-6 py-10">
        <h1 class="text-2xl font-bold text-indigo-700 mb-6">Tambah Ekstrakurikuler</h1>
        <!-- Notifikasi -->
        <div id="notification" clas="hidden"></div>
        <form id="createForm" class="space-y-4 bg-white shadow-md rounded-lg p-6">
            @csrf
            <div>
                <label class="block text-sm font-medium">Nama Ekstrakurikuler</label>
                <input type="text" name="nama_ekskul" required
                    class="w-full border rounded px-3 py-2 mt-1 focus:ring focus:ring-indigo-200">
            </div>
            <div>
                <label class="block text-sm font-medium">Pembina</label>
                <input type="text" name="pembina" required
                    class="w-full border rounded px-3 py-2 mt-1 focus:ring focus: ring-indigo-200">
            </div>
            <div>
                <label class="block text-sm font-medium">Jadwal</label>
                <input type="text" name="jadwal"
                    class="w-full border rounded px-3 py-2 mt-1 focus:ring focus:ring-indigo-200">
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
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
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
</x-layouts.main>

