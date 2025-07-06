<x-guest-layout>
    <div 
         class="bg-gradient-to-tr from-blue-900 to-cyan-700 dark:from-gray-900 dark:to-gray-800 min-h-screen flex flex-col text-white">

        <!-- Navbar superior -->
        <nav class="flex justify-between items-center px-8 py-4 shadow-md bg-white/10 backdrop-blur-md dark:bg-gray-900/50">
            <h1 class="text-2xl font-bold text-cyan-300 tracking-wide">🧾 FacturaPro</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}"
                   class="px-4 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg font-medium transition">
                   Iniciar sesión
                </a>
                <a href="{{ route('register') }}"
                   class="px-4 py-2 bg-cyan-800 hover:bg-cyan-700 text-white rounded-lg font-medium transition">
                   Registrarse
                </a>

                <!-- Switch modo oscuro -->
                

            </div>
        </nav>

        <!-- Contenido principal -->
        <main class="flex-1 flex items-center justify-center px-4">
            <div class="text-center max-w-2xl">
                <h2 class="text-5xl font-extrabold mb-6 text-cyan-100">
                    Administra tus productos y ventas con facilidad
                </h2>
                <p class="text-lg text-gray-200 mb-8">
                    Nuestro sistema de facturación web te permite crear, registrar y visualizar productos, usuarios y más.
                    Todo en un solo lugar. Sin complicaciones.
                </p>
                <a href="{{ route('login') }}"
                   class="inline-block bg-cyan-600 hover:bg-cyan-500 px-6 py-3 rounded-full text-lg font-semibold text-white shadow-lg transition">
                   Comenzar ahora
                </a>
            </div>
        </main>

        <!-- Footer -->
        <footer class="text-center py-4 text-gray-300 text-sm">
            &copy; {{ date('Y') }} FacturaWeb. Todos los derechos reservados.
        </footer>
    </div>
</x-guest-layout>
