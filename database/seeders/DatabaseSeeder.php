<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios de prueba por rol
        $admin = User::create([
            'name'     => 'Admin EatHidden',
            'email'    => 'admin@eathidden.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'phone'    => '999-000-001',
        ]);

        $kitchen = User::create([
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
        $hamburguesasCat = Category::create(['name' => 'Hamburguesas', 'description' => 'Burgers artesanales', 'active' => true]);
        $tacosCat        = Category::create(['name' => 'Tacos & Burritos', 'description' => 'Cocina mexicana', 'active' => true]);
        $ramiCat         = Category::create(['name' => 'Ramen & Noodles', 'description' => 'Cocina asiática', 'active' => true]);
        $pizzaCat        = Category::create(['name' => 'Pizzas', 'description' => 'Pizzas al horno de piedra', 'active' => true]);
        $bebidasCat      = Category::create(['name' => 'Bebidas', 'description' => 'Bebidas frías y calientes', 'active' => true]);

        // Platos
        $dishes = [
            // Hamburguesas
            ['category_id' => $hamburguesasCat->id, 'name' => 'Burger Clásica', 'description' => 'Carne angus, queso cheddar, lechuga, tomate y salsa especial.', 'price' => 28.00, 'available' => true],
            ['category_id' => $hamburguesasCat->id, 'name' => 'Burger BBQ Crispy', 'description' => 'Pollo crocante, salsa BBQ ahumada, cebolla caramelizada.', 'price' => 32.00, 'available' => true],
            ['category_id' => $hamburguesasCat->id, 'name' => 'Burger Doble', 'description' => 'Doble carne, doble queso, bacon, encurtidos y mostaza.', 'price' => 42.00, 'available' => true],
            // Tacos
            ['category_id' => $tacosCat->id, 'name' => 'Taco al Pastor', 'description' => 'Cerdo marinado, piña, cilantro y cebolla. x3 unidades.', 'price' => 22.00, 'available' => true],
            ['category_id' => $tacosCat->id, 'name' => 'Burrito Carnitas', 'description' => 'Cerdo deshebrado, arroz, frijoles, guacamole y crema.', 'price' => 30.00, 'available' => true],
            // Ramen
            ['category_id' => $ramiCat->id, 'name' => 'Ramen Tonkotsu', 'description' => 'Caldo de cerdo 12h, huevo marinado, nori y chashu.', 'price' => 38.00, 'available' => true],
            ['category_id' => $ramiCat->id, 'name' => 'Ramen Miso Vegano', 'description' => 'Base miso, tofu, maíz, champiñones y algas.', 'price' => 34.00, 'available' => true],
            // Pizzas
            ['category_id' => $pizzaCat->id, 'name' => 'Pizza Margherita', 'description' => 'Salsa de tomate, mozzarella fresca y albahaca.', 'price' => 35.00, 'available' => true],
            ['category_id' => $pizzaCat->id, 'name' => 'Pizza Pepperoni', 'description' => 'Salsa de tomate, mozzarella y pepperoni artesanal.', 'price' => 40.00, 'available' => true],
            // Bebidas
            ['category_id' => $bebidasCat->id, 'name' => 'Limonada Frozen', 'description' => 'Limón, hielo y menta fresca.', 'price' => 10.00, 'available' => true],
            ['category_id' => $bebidasCat->id, 'name' => 'Agua con gas', 'description' => 'Botella 600ml.', 'price' => 5.00, 'available' => true],
        ];

        foreach ($dishes as $dishData) {
            Dish::create($dishData);
        }

        // Pedido de prueba
        $burger  = Dish::where('name', 'Burger Clásica')->first();
        $ramen   = Dish::where('name', 'Ramen Tonkotsu')->first();
        $limon   = Dish::where('name', 'Limonada Frozen')->first();

        $order = Order::create([
            'client_id'        => $client->id,
            'status'           => 'preparing',
            'total'            => ($burger->price * 2) + $ramen->price + $limon->price,
            'delivery_address' => $client->address,
            'notes'            => 'Sin cebolla en las hamburguesas.',
        ]);

        $order->items()->createMany([
            ['dish_id' => $burger->id, 'quantity' => 2, 'unit_price' => $burger->price],
            ['dish_id' => $ramen->id,  'quantity' => 1, 'unit_price' => $ramen->price],
            ['dish_id' => $limon->id,  'quantity' => 1, 'unit_price' => $limon->price],
        ]);
    }
}
