<?php

namespace Database\Factories;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionValueFactory extends Factory
{
    protected $model = OptionValue::class;

    public function definition()
    {
        return [
            'option_id' => Option::factory(), // Create a related option
            'value' => $this->faker->randomElement(['Red', 'Blue', 'Green', 'Large', 'Small']), // Random value
        ];
    }
}
