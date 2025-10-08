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