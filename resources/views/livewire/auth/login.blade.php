<body class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('images/bg.png') }}'); background-size: cover; background-position: center;">
    <div class="w-full max-w-sm bg-white backdrop-blur-md rounded-3xl shadow-xl border border-gray-400 p-6 sm:p-8">

        <!-- Logo e introducción -->
        <div class="text-center mb-4">
            <div class="flex items-center justify-between">
                <img src="{{ asset('images/app_logo.png') }}" alt="StockMate" class="w-12 rounded-md shadow-sm">
                <h2 class="text-lg sm:text-xl font-extrabold text-gray-800">¡Bienvenido a StockMate!</h2>
            </div>
            <p class="text-center text-sm text-gray-600 mt-2">Gestiona tu papelería con estilo 🖍️</p>
        </div>

        <!-- Estado de sesión -->
        <x-auth-session-status class="text-center text-cyan-600 mb-4" :status="session('status')" />

        <!-- Formulario -->
        <form wire:submit.prevent="login" class="flex flex-col gap-5">
            <!-- Correo -->
            <div>
                <label for="correo" class="block text-gray-700 font-medium mb-1">{{ __('Correo electrónico') }}</label>
                <input
                    id="correo"
                    type="email"
                    wire:model="correo"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="ejemplo@papeleria.com"
                    class="w-full rounded-lg bg-white border-2 border-gray-400 px-4 py-2 shadow-md focus:ring-2 focus:ring-gray-500 transition duration-200 ease-in-out"
                />
            </div>
            
            <!-- Contraseña -->
            <div class="relative">
                <label for="password" class="block text-gray-700 font-medium mb-1">{{ __('Contraseña') }}</label>
                <input
                    id="password"
                    type="password"
                    wire:model="password"
                    required
                    autocomplete="current-password"
                    placeholder="Tu contraseña secreta"
                    class="w-full rounded-lg bg-white border-2 border-gray-400 px-4 py-2 shadow-md focus:ring-2 focus:ring-gray-500 transition duration-200 ease-in-out"
                />
                {{-- 
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="absolute end-38 top-18 text-sm text-yellow-500 hover:text-yellow-600 mt-1 whitespace-nowrap">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>            
                @endif 
                --}}
            </div>        

            <!-- Recuérdame -->
            <div class="flex items-center gap-4 text-gray-600 mt-4">
                <input type="checkbox" wire:model="remember" id="remember" class="h-5 w-5">
                <label for="remember">{{ __('Recuérdame') }}</label>
            </div>

            <!-- Botón -->
            <button
                type="submit"
                class="w-full bg-teal-500 text-white font-bold py-3 rounded-lg transition hover:bg-teal-700 shadow-md"
            >
                {{ __('Iniciar Sesión') }}
            </button>
        </form>

        <!-- Enlace de registro -->
        @if (Route::has('register'))
            <div class="mt-4 text-center text-sm text-gray-600">
                {{ __("¿No tienes cuenta?") }}
                <a href="{{ route('register') }}" class="text-cyan-700 font-semibold hover:text-cyan-900">
                    {{ __('Regístrate aquí') }}
                </a>
            </div>
        @endif
    </div>
</body>
