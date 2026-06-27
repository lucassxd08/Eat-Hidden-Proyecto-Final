<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-white">Bienvenido de vuelta</h2>
        <p class="text-gray-500 mt-1 text-sm">Inicia sesión para continuar</p>
    </div>

    @if(session('status'))
        <div class="mb-5 bg-green-900 border border-green-700 text-green-300 px-4 py-3 rounded-lg text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Correo electrónico</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
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
                    placeholder="••••••••">
            </div>
            @error('password')
                <p class="mt-1.5 text-red-400 text-xs">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition text-sm mt-2">
            Iniciar sesión
        </button>

        <p class="text-center text-gray-500 text-sm pt-1">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="text-red-400 hover:text-red-300 font-medium transition">Ir a registro</a>
        </p>
    </form>
</x-guest-layout>
