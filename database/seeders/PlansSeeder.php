<?php

namespace Database\Seeders;

use App\Models\Subscription\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'key'   => 'yearly_plan',
            'name'  => 'Yearly subscription',
            'short_description' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم',
            'features'  => [],
            'price'     => 950,
            'currency'   => 'SAR',
            'billing_interval'  => 'year',
            'billing_period'    => 1,
            'sort_order'    => 1,
            'is_active' => 1,
            'is_featured'   => 1
        ]);

        Plan::create([
            'key'   => 'monthly_plan',
            'name'  => 'monthly subscription',
            'short_description' => 'لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم',
            'features'  => [],
            'price'     => 120,
            'currency'   => 'SAR',
            'billing_interval'  => 'month',
            'billing_period'    => 1,
            'sort_order'    => 2,
            'is_active' => 1,
            'is_featured'   => 0
        ]);
    }
}
