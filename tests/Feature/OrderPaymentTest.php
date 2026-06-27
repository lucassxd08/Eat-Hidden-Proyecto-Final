<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_client_can_store_an_order_with_yape_payment(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'client',
            'address' => 'Av. Siempre Viva 123',
        ]);

        $restaurant = Restaurant::create([
            'name' => 'Restaurante Test',
            'description' => 'Prueba',
            'active' => true,
        ]);

        $category = Category::create([
            'name' => 'Platos',
        ]);

        $dish = Dish::create([
            'restaurant_id' => $restaurant->id,
            'category_id' => $category->id,
            'name' => 'Lomo Saltado',
            'description' => 'Delicioso',
            'price' => 25.50,
            'available' => true,
        ]);

        $response = $this->actingAs($user)->post(route('orders.store'), [
            'delivery_address' => 'Calle Falsa 123',
            'notes' => 'Sin cebolla',
            'payment_method' => 'Yape',
            'items' => [
                ['dish_id' => $dish->id, 'quantity' => 2],
            ],
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'client_id' => $user->id,
            'metodo_pago' => 'Yape',
            'estado_pago' => 'Pendiente',
        ]);

        $order = \App\Models\Order::latest()->first();
        $this->assertNotNull($order->fecha_pago);
    }
}
