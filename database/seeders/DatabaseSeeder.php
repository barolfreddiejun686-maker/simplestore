<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
class DatabaseSeeder extends Seeder
{
public function run(): void
{
// 1. Create admin user first
$this->call(AdminSeeder::class);
// 2. Create 10 regular customers
User::factory(10)->create();
// 3. Create 5 categories
Category::factory(5)->create();
// 4. Create 20 products (needs categories first)
Product::factory(20)->create();
// 5. Create 10 orders (needs users first)
Order::factory(10)->create();
// 6. Create 30 order items (needs orders and products first)
OrderItem::factory(30)->create();
}
}