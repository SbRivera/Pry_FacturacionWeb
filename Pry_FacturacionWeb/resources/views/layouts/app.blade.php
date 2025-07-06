<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="transition-colors duration-500 ease-in-out">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Facturación Pro') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('darkMode', {
            on: localStorage.getItem('darkMode') === 'true',
            toggle() {
                this.on = !this.on;
                localStorage.setItem('darkMode', this.on);
                document.documentElement.classList.toggle('dark', this.on);
            }
        });
        // Set initial state
        if (Alpine.store('darkMode').on) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });
</script>

</head>
<body
    class="bg-gradient-to-br from-blue-950 via-blue-900 to-cyan-800 text-white min-h-screen antialiased transition-all duration-500"
>
    <div
        x-data="{
            open: true,  // Inicia abierto en desktop
            darkMode: localStorage.getItem('darkMode') === 'true'
        }"
        x-init="
            $watch('darkMode', val => {
                localStorage.setItem('darkMode', val);
                document.documentElement.classList.toggle('dark', val);
            });
            window.addEventListener('resize', () => {
                if(window.innerWidth < 768) open = false;
                else open = true;
            });
        "
        class="flex"
    >
        <!-- Sidebar -->
        <aside
            :class="open ? 'translate-x-0' : '-translate-x-64'"
            class="fixed z-40 inset-y-0 left-0 w-64 bg-blue-800 shadow-lg transform transition-transform duration-300 ease-in-out"
            style="will-change: transform;"
        >
            <div class="p-6 flex flex-col h-full">
                <!-- Icono o logo -->
                <div class="flex items-center mb-8 space-x-3">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-10 w-10 text-cyan-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18M7 6h10l1 8-1 4H7l-1-4 1-8z" />
                    </svg>
                    <h2 class="text-2xl font-bold text-cyan-300 select-none">FacturaPro</h2>
                </div>

                <nav class="flex-grow">
                    <ul class="space-y-5">
                        <li>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-md hover:bg-cyan-700 transition">
                                <div class="flex items-center space-x-3">
                                    <svg
                                        class="h-6 w-6 text-cyan-400"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                                        <path d="M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                    </svg>
                                    <span>Dashboard</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/') }}" class="block px-4 py-2 rounded-md hover:bg-cyan-700 transition">
                                <div class="flex items-center space-x-3">
                                    <svg
                                        class="h-6 w-6 text-cyan-400"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                                        <path d="M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                    </svg>
                                    <span>Inicio</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/profile') }}" class="block px-4 py-2 rounded-md hover:bg-cyan-700 transition">
                                <div class="flex items-center space-x-3">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-cyan-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1118.878 6.196 9 9 0 015.12 17.804z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Perfil</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="mt-auto pt-6 text-center text-cyan-400 text-xs select-none">
                    © {{ date('Y') }} FactuPro. All rights reserved.
                </div>
            </div>
        </aside>

        <!-- Main content -->
        <div class="flex-1 min-h-screen transition-all duration-300" :class="open ? 'ml-64' : 'ml-0'">

            <!-- Navbar -->
            <nav
                class="flex items-center justify-between bg-blue-900 py-3 px-6 shadow-md flex-shrink-0"
            >
                <button
                    @click="open = !open"
                    class="text-white focus:outline-none"
                    aria-label="Toggle sidebar"
                >
                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="flex items-center gap-6 ml-auto">
                    <!-- Switch modo oscuro -->
                    


                    <!-- Usuario -->
                    <div class="text-sm text-cyan-200 select-none">
                        {{ Auth::user()->name ?? 'Invitado' }}
                    </div>
                </div>
            </nav>

            <!-- Main slot -->
            <main class="flex-grow p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
