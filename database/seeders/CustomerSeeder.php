<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerGroup;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $groups = CustomerGroup::factory(5)->create();

        Customer::factory(20)->create()->each(function ($customer) use ($groups) {
            $customer->customerGroups()->attach(
                $groups->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
