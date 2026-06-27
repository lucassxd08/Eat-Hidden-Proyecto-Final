<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios
        $admin = User::create([
            'name'     => 'Admin EatHidden',
            'email'    => 'admin@eathidden.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '999-000-001',
        ]);

        User::create([
            'name'     => 'Chef Carlos',
            'email'    => 'cocina@eathidden.com',
            'password' => Hash::make('password'),
            'role'     => 'kitchen',
        ]);

        $delivery = User::create([
            'name'     => 'Repartidor Luis',
            'email'    => 'delivery@eathidden.com',
            'password' => Hash::make('password'),
            'role'     => 'delivery',
            'phone'    => '999-000-003',
        ]);

        $client = User::create([
            'name'     => 'Cliente Ana',
            'email'    => 'cliente@eathidden.com',
            'password' => Hash::make('password'),
            'role'     => 'client',
            'phone'    => '999-000-004',
            'address'  => 'Av. Larco 450, Miraflores',
        ]);

        // Categorías
        $hamburguesasCat = Category::create(['name' => 'Hamburguesas',    'description' => 'Burgers artesanales',        'active' => true]);
        $tacosCat        = Category::create(['name' => 'Tacos & Burritos','description' => 'Cocina mexicana',            'active' => true]);
        $ramiCat         = Category::create(['name' => 'Ramen & Noodles', 'description' => 'Cocina asiática',           'active' => true]);
        $pizzaCat        = Category::create(['name' => 'Pizzas',          'description' => 'Pizzas al horno de piedra', 'active' => true]);
        $bebidasCat      = Category::create(['name' => 'Bebidas',         'description' => 'Bebidas frías y calientes', 'active' => true]);

        // Restaurantes (dark kitchens)
        $burgerKitchen = Restaurant::create([
            'name'        => 'Burger Underground',
            'description' => 'Dark kitchen especializada en hamburguesas artesanales con ingredientes premium.',
            'active'      => true,
        ]);

        $mexicanKitchen = Restaurant::create([
            'name'        => 'La Cocina Oculta',
            'description' => 'Auténtica comida mexicana preparada por chefs con técnicas tradicionales.',
            'active'      => true,
        ]);

        $asianKitchen = Restaurant::create([
            'name'        => 'Ramen Lab',
            'description' => 'Especialistas en ramen con caldos preparados por más de 12 horas.',
            'active'      => true,
        ]);

        $pizzaKitchen = Restaurant::create([
            'name'        => 'Pizza Secreta',
            'description' => 'Pizzas al horno de piedra con masa madre y ingredientes importados.',
            'active'      => true,
        ]);

        // Platos — Burger Underground
        $burger1 = Dish::create(['restaurant_id' => $burgerKitchen->id, 'category_id' => $hamburguesasCat->id, 'name' => 'Burger Clásica',       'description' => 'Carne angus, queso cheddar, lechuga, tomate y salsa especial.',         'price' => 28.00, 'available' => true]);
        $burger2 = Dish::create(['restaurant_id' => $burgerKitchen->id, 'category_id' => $hamburguesasCat->id, 'name' => 'Burger BBQ Crispy',    'description' => 'Pollo crocante, salsa BBQ ahumada, cebolla caramelizada.',              'price' => 32.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $burgerKitchen->id, 'category_id' => $hamburguesasCat->id, 'name' => 'Burger Doble',         'description' => 'Doble carne angus, doble queso, bacon y encurtidos.',                  'price' => 42.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $burgerKitchen->id, 'category_id' => $hamburguesasCat->id, 'name' => 'Burger Mushroom',      'description' => 'Carne angus, champiñones salteados, queso suizo y mayonesa de ajo.',   'price' => 35.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $burgerKitchen->id, 'category_id' => $hamburguesasCat->id, 'name' => 'Burger Vegana',        'description' => 'Medallón de garbanzo, aguacate, tomate y hojas verdes.',               'price' => 30.00, 'available' => true]);
        $limon   = Dish::create(['restaurant_id' => $burgerKitchen->id, 'category_id' => $bebidasCat->id,      'name' => 'Limonada Frozen',      'description' => 'Limón, hielo y menta fresca.',                                         'price' => 10.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $burgerKitchen->id, 'category_id' => $bebidasCat->id,      'name' => 'Milkshake Oreo',       'description' => 'Helado de vainilla, galletas oreo y crema batida.',                    'price' => 14.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $burgerKitchen->id, 'category_id' => $bebidasCat->id,      'name' => 'Gaseosa 500ml',        'description' => 'Coca-Cola, Inca Kola o Sprite. A elección.',                           'price' => 7.00,  'available' => true]);

        // Platos — La Cocina Oculta
                   Dish::create(['restaurant_id' => $mexicanKitchen->id, 'category_id' => $tacosCat->id,       'name' => 'Taco al Pastor',       'description' => 'Cerdo marinado, piña, cilantro y cebolla. x3 unidades.',              'price' => 22.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $mexicanKitchen->id, 'category_id' => $tacosCat->id,       'name' => 'Taco de Birria',       'description' => 'Res estofada, queso oaxaca, cebolla y cilantro. Con consomé.',        'price' => 26.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $mexicanKitchen->id, 'category_id' => $tacosCat->id,       'name' => 'Taco de Camarón',      'description' => 'Camarones a la plancha, repollo, pico de gallo y crema.',            'price' => 28.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $mexicanKitchen->id, 'category_id' => $tacosCat->id,       'name' => 'Burrito Carnitas',     'description' => 'Cerdo deshebrado, arroz, frijoles, guacamole y crema.',              'price' => 30.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $mexicanKitchen->id, 'category_id' => $tacosCat->id,       'name' => 'Burrito Pollo',        'description' => 'Pollo a la plancha, arroz, frijoles negros y pico de gallo.',        'price' => 27.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $mexicanKitchen->id, 'category_id' => $bebidasCat->id,     'name' => 'Agua de Jamaica',      'description' => 'Bebida fresca de flor de Jamaica. 500ml.',                           'price' => 8.00,  'available' => true]);
                   Dish::create(['restaurant_id' => $mexicanKitchen->id, 'category_id' => $bebidasCat->id,     'name' => 'Horchata',             'description' => 'Bebida de arroz con canela y vainilla. 500ml.',                      'price' => 8.00,  'available' => true]);
                   Dish::create(['restaurant_id' => $mexicanKitchen->id, 'category_id' => $bebidasCat->id,     'name' => 'Margarita Sin Alcohol','description' => 'Limón, sal, jarabe de agave y hielo triturado.',                    'price' => 12.00, 'available' => true]);

        // Platos — Ramen Lab
        $ramen   = Dish::create(['restaurant_id' => $asianKitchen->id,  'category_id' => $ramiCat->id,         'name' => 'Ramen Tonkotsu',       'description' => 'Caldo de cerdo 12h, huevo marinado, nori y chashu.',                 'price' => 38.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $asianKitchen->id,  'category_id' => $ramiCat->id,         'name' => 'Ramen Miso Vegano',    'description' => 'Base miso, tofu, maíz, champiñones y algas.',                       'price' => 34.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $asianKitchen->id,  'category_id' => $ramiCat->id,         'name' => 'Ramen Shoyu Pollo',    'description' => 'Caldo de pollo y soya, pechuga, nori, huevo y bambú.',              'price' => 36.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $asianKitchen->id,  'category_id' => $ramiCat->id,         'name' => 'Ramen Spicy Mala',     'description' => 'Caldo picante con aceite de sésamo, cerdo y espinacas.',            'price' => 40.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $asianKitchen->id,  'category_id' => $bebidasCat->id,      'name' => 'Té Verde Helado',      'description' => 'Té verde japonés con hielo y limón. 400ml.',                        'price' => 9.00,  'available' => true]);
                   Dish::create(['restaurant_id' => $asianKitchen->id,  'category_id' => $bebidasCat->id,      'name' => 'Agua de Coco',         'description' => 'Agua de coco natural, fría. 330ml.',                                'price' => 8.00,  'available' => true]);

        // Platos — Pizza Secreta
                   Dish::create(['restaurant_id' => $pizzaKitchen->id,  'category_id' => $pizzaCat->id,        'name' => 'Pizza Margherita',     'description' => 'Salsa de tomate, mozzarella fresca y albahaca.',                    'price' => 35.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $pizzaKitchen->id,  'category_id' => $pizzaCat->id,        'name' => 'Pizza Pepperoni',      'description' => 'Salsa de tomate, mozzarella y pepperoni artesanal.',                'price' => 40.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $pizzaKitchen->id,  'category_id' => $pizzaCat->id,        'name' => 'Pizza 4 Quesos',       'description' => 'Mozzarella, gorgonzola, parmesano y brie sobre base de crema.',    'price' => 45.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $pizzaKitchen->id,  'category_id' => $pizzaCat->id,        'name' => 'Pizza Prosciutto',     'description' => 'Jamón crudo, rúcula, parmesano y aceite de oliva al terminar.',    'price' => 48.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $pizzaKitchen->id,  'category_id' => $pizzaCat->id,        'name' => 'Pizza Trufa Negra',    'description' => 'Crema de trufa negra, champiñones, mozzarella y romero.',          'price' => 52.00, 'available' => true]);
                   Dish::create(['restaurant_id' => $pizzaKitchen->id,  'category_id' => $bebidasCat->id,      'name' => 'Agua con gas',         'description' => 'Botella 600ml.',                                                    'price' => 5.00,  'available' => true]);
                   Dish::create(['restaurant_id' => $pizzaKitchen->id,  'category_id' => $bebidasCat->id,      'name' => 'Limonada Italiana',    'description' => 'Limón, agua con gas, azúcar y menta. 500ml.',                      'price' => 11.00, 'available' => true]);

        // Pedido de prueba
        $order = Order::create([
            'client_id'        => $client->id,
            'status'           => 'preparing',
            'total'            => ($burger1->price * 2) + $ramen->price + $limon->price,
            'delivery_address' => $client->address,
            'notes'            => 'Sin cebolla en las hamburguesas.',
        ]);

        $order->items()->createMany([
            ['dish_id' => $burger1->id, 'quantity' => 2, 'unit_price' => $burger1->price],
            ['dish_id' => $ramen->id,   'quantity' => 1, 'unit_price' => $ramen->price],
            ['dish_id' => $limon->id,   'quantity' => 1, 'unit_price' => $limon->price],
        ]);
    }
}
