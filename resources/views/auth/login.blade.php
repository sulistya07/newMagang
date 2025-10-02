<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ekstrakurikuler SMKN 7 Batam</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold text-center text-indigo-700 mb-6">
            Login ke Sistem
        </h2>

        {{-- Error Message --}}
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg">
                <ul class="text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Login --}}
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
                           focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm 
                               focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm pr-10">
                    <button type="button" onclick="togglePassword()" 
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500">
                        <i data-feather="eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition">
                Login
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Hanya admin bisa login
        </p>
    </div>

    <script>
        feather.replace();

        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.setAttribute("data-feather", "eye-off");
            } else {
                passwordInput.type = "password";
                eyeIcon.setAttribute("data-feather", "eye");
            }
            feather.replace();
        }
    </script>
</body>
</html>
