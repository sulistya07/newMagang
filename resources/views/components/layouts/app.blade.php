<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Ekstrakurikuler SMKN 7 Batam'}}</title>
    <link rel="icon" type="images/png" href="{{ asset('images/smkn7.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans bg-gray-50 text-gray-800">
    {{-- Navbar --}}
    <header class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-centre">
            {{-- Logo _Nama Sekolah --}}
            <div class="flex items-centre gap-3">
                <img src="{{asset('images/smkn7.png')}}" alt="Logo SMKN7 Batam" class="h-10 w-10">
                <h1 class="text-xl font-bold text-indigo-700">SMKN 7 Batam</h1>
            </div>
            {{-- Menu Navigasi --}}
            <nav class="hidden md:flex gap-6">
                <a href="#ekstrakurikuler" class="hover:text-indigo-600">Ekstrakurikuler</a>
                <a href="#prestasi" class="hover:text-indigo-600">Prestasi</a>
                <a href="#fotokegiatan" class="hover:text-indigo-600">Foto Kegiatan</a>
                <a href="{{ route('login') }}" class="hover:text-indigo-600">Login</a>
            </nav>
        </div>
    </header>
    <main>
        {{ $slot }}
    </main>
</body>
</html>