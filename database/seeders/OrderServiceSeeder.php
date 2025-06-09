<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderService;
use App\Models\Technician;

class OrderServiceSeeder extends Seeder
{
    public function run(): void
    {
        OrderService::factory()
            ->count(20)
            ->create()
            ->each(function ($order) {
                $technicians = Technician::inRandomOrder()->take(rand(1, 3))->get();

                foreach ($technicians as $tech) {
                    $order->technicians()->attach($tech->id, [
                        'hours_worked' => rand(1, 20),
                        'role' => fake()->randomElement(['Leader', 'Assistant']),
                        'notes' => fake()->optional()->sentence
                    ]);
                }
            });
    }
}
