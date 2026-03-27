<?php
namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
class OrderFactory extends Factory
{
public function definition(): array
{
return [
'user_id' => User::inRandomOrder()->first()->id,
'name' => fake()->name(),
'email' => fake()->safeEmail(),
'phone' => fake()->phoneNumber(),
'address' => fake()->address(),
'total_amount' => fake()->randomFloat(2, 50, 1000),
'status' => fake()->randomElement([
'pending', 'processing',
'shipped', 'delivered', 'cancelled'
]),
];
}
}