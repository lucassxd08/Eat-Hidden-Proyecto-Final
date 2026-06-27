<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-white">Crear cuenta</h2>
        <p class="text-gray-500 mt-1 text-sm">Regístrate para empezar a pedir</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Nombre completo</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full bg-zinc-900 border border-zinc-700 text-white rounded-lg pl-10 pr-4 py-3 text-sm focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 placeholder-gray-600 @error('name') border-red-500 @enderror"
                    placeholder="Tu nombre">
            </div>
            @error('name')
                <p class="mt-1.5 text-red-400 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Correo electrónico</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full bg-zinc-900 border border-zinc-700 text-white rounded-lg pl-10 pr-4 py-3 text-sm focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 placeholder-gray-600 @error('email') border-red-500 @enderror"
                    placeholder="tucorreo@ejemplo.com">
            </div>
            @error('email')
                <p class="mt-1.5 text-red-400 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Contraseña</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input type="password" name="password" required
                    class="w-full bg-zinc-900 border border-zinc-700 text-white rounded-lg pl-10 pr-4 py-3 text-sm focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 @error('password') border-red-500 @enderror"
                    placeholder="Mínimo 8 caracteres">
            </div>
            @error('password')
                <p class="mt-1.5 text-red-400 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Confirmar contraseña</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input type="password" name="password_confirmation" required
                    class="w-full bg-zinc-900 border border-zinc-700 text-white rounded-lg pl-10 pr-4 py-3 text-sm focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500"
                    placeholder="Repite tu contraseña">
            </div>
        </div>

        <button type="submit"
            class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition text-sm mt-2">
            Crear cuenta
        </button>

        <p class="text-center text-gray-500 text-sm pt-1">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="text-red-400 hover:text-red-300 font-medium transition">Iniciar sesión</a>
        </p>
    </form>
</x-guest-layout>
