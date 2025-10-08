<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Ekstrakurikuler' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-md flex flex-col">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-indigo-700">Ekstrakurikuler</h1>
            </div>
            <nav class="flex-1 p-6 space-y-4">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-indigo-100">Dashboard</a>
                <a href="{{ route('ekstrakurikuler.index') }}" 
                    class="block px-3 py-2 rounded {{ request()->routeIs('ekstrakurikuler.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'hover:bg-indigo-100' }}">
                    Ekstrakurikuler
                </a>
                <a href="#prestasi" class="block px-3 py-2 rounded hover:bg-indigo-100">Prestasi</a>
                <a href="#foto" class="block px-3 py-2 rounded hover:bg-indigo-100">Foto Kegiatan</a>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">

            {{-- Header --}}
            <header class="bg-white shadow flex justify-between items-center px-7 py-4">
                <h2 class="text-lg font-semibold text-gray-700">
                    Selamat datang, <span class="text-indigo-600">{{ Auth::user()->name }}</span>
                </h2>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </header>

            {{-- Main Body --}}
            <main class="flex-1 p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
