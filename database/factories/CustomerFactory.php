<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fl_name' => $this->faker->name,
            'full_name' => $this->faker->company,
            'phone' => $this->faker->tollFreePhoneNumber,
            'address' => $this->faker->address,
            'inn' => $this->faker->numberBetween($min = 10000000, $max = 90000000),
            'kpp' => $this->faker->numberBetween($min = 100000, $max = 900000),
            'ogrn' => $this->faker->numberBetween($min = 1000000000, $max = 9000000000),
        ];
    }
}
