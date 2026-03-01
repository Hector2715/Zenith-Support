<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan; // Importante

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        // Plan Básico
        Plan::create([
            'name' => 'Plan Básico',
            'slug' => 'plan-basico',
            'stripe_id' => 'price_1T1fCIJorkeXUUtTFL09xiXi',
            'price' => 999, // 9.99 dólares (en centavos)
            'description' => 'Ideal para empezar tu portafolio personal.'
        ]);

        // Plan Pro
        Plan::create([
            'name' => 'Plan Pro',
            'slug' => 'plan-pro',
            'stripe_id' => 'price_1T1fHwJorkeXUUtTqKqSynBM',
            'price' => 1999, // 19.99 dólares (en centavos)
            'description' => 'Perfecto para freelancers con múltiples proyectos.'
        ]);
    }
}