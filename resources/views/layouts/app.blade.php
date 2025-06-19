<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'LKE ZI Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body class="bg-white text-[#146082]">
    <div class="flex min-h-screen">
        @auth
        <!-- Sidebar -->
         @include('admin.sidebar')
        @endauth

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Navbar -->
            @include('components.navbar')

            <!-- Content -->
            <main class="flex-1 bg-[#e9f7fc] rounded-tl-lg">
                <div class="p-8">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            @include('components.footer')
        </div>
    </div>
    @stack('scripts')
</body>
</html>
