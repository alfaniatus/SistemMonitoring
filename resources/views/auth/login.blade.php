<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign In</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="flex w-1/2 rounded-md overflow-hidden">
        <!-- Left -->
        <div class="w-1/2 bg-white flex flex-col justify-center items-center text-center">
            <h2 class="text-[#146082] text-lg font-bold mb-6">
                Lembar Kerja Evaluasi <br> Zona Integritas
            </h2>
            <img src="{{ asset('images/globe.png') }}" alt="Globe" class="w-52">
        </div>

        <!-- Right -->
        <div class="w-1/2 bg-[#146082] text-white p-10 flex flex-col justify-center">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12">
            </div>

            <form method="POST" action="{{ route('auth.login') }}" class="space-y-6">
                @csrf

                @if ($errors->any())
                    <div class=" text-white">
                        <ul class="text-xs">
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <label for="email" class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-1.5 rounded-md text-black focus:outline-none focus:ring-2 focus:ring-white">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-1.5 rounded-md text-black focus:outline-none focus:ring-2 focus:ring-white">
                    <div class="text-right -mt-1">
                        <a href="#" class="text-xs hover:text-blue-300">Forgot Password?</a>
                    </div>
                </div>

                <div class="flex justify-center">
                    <a href="{{ route('admin.dashboard') }}" ></a>
                    <button type="submit"
                        class="w-1/2 text-center bg-white text-[#146082] font-semibold py-1.5 rounded-md hover:bg-gray-200 transition">
                        Sign In
                        </button>
                </div>
        </div>
        </form>
    </div>
    </div>

</body>

</html>
