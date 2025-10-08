@@props(['ekskul'])

<section id="ekstrakurikuler" class="py-20">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h3 class="text-3xl font-bold mb-12">Ekstrakurikuler Siswa</h3>
{{-- Wrapper scroll horizontal --}}
<div id="ekskul-slider" class="flex gap-6 overflow-x-auto scroll-smooth snap-x snap-mandatory pb-4">
    @@forelse ($ekskul as $item)
        <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-xl shadow hover:shadow-lg transition p-4 snap-center">
            <div class="w-full h-48 flex items-center justify-center bg-gray-100 rounded-lg mb-4">
                <img src="{{ asset('images/smkn7.png')}}"
                    class="max-h-48 object-contain"
                    alt="{{ $item->nama_ekskul }}">
            </div>
            <h4 class="text-xl font-semibold">{{ $item->nama_ekskul }}</h4>
            <p class="text-sm text-gray-600">Pembina: {{ $item->jadwal }}</p>
            @@if ($item->jadwal)
                <p class="text-sm text-gray-500 mt-1">Jadwal: {{ $item->jadwal }}</p>
            @@endif
            @@if ($item->kuota)
                <p class="text-sm text-gray-500">Kuota: {{ $item->kuota }} siswa</p>
            @@endif   
        </div>  
    @@empty
        <p class="text-gray-500">Belum ada ekstrakurikuler yang ditambahkan.</p>
    @@endforelse
</div>
</div>
</section>
<script src= "{{ asset('js/ekstrakurikuler/scrolllanding.js') }}">
</script>