@extends('layouts.app')
@section('title', 'Nosotros')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-16">
    <h1 class="text-4xl font-bold text-gray-900 mb-4">¿Quiénes somos?</h1>
    <p class="text-gray-500 text-lg mb-12">La plataforma que conecta dark kitchens con sus clientes.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
        <div>
            <h2 class="text-2xl font-bold mb-4 text-orange-500">Nuestra misión</h2>
            <p class="text-gray-600 leading-relaxed">
                EatHidden nació para dar visibilidad a los mejores cocineros que operan
                sin un local físico. Creemos que la calidad no necesita cuatro paredes:
                solo necesita pasión, ingredientes frescos y un buen sistema de delivery.
            </p>
        </div>
        <div>
            <h2 class="text-2xl font-bold mb-4 text-orange-500">¿Qué es una dark kitchen?</h2>
            <p class="text-gray-600 leading-relaxed">
                Una dark kitchen es un restaurante 100% orientado al delivery: sin salón,
                sin atención presencial. Esto permite reducir costos y enfocarse únicamente
                en preparar comida de alta calidad para envío a domicilio.
            </p>
        </div>
    </div>

    <div class="bg-gray-900 text-white rounded-2xl p-10 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
        <div>
            <p class="text-5xl font-bold text-orange-400 mb-2">100%</p>
            <p class="text-gray-300">Enfoque en delivery</p>
        </div>
        <div>
            <p class="text-5xl font-bold text-orange-400 mb-2">4</p>
            <p class="text-gray-300">Roles especializados</p>
        </div>
        <div>
            <p class="text-5xl font-bold text-orange-400 mb-2">30'</p>
            <p class="text-gray-300">Tiempo promedio de entrega</p>
        </div>
    </div>
</div>
@endsection
