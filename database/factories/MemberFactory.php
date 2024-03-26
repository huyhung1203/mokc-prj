<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $code = 'M' . str_pad(fake()->unique()->numberBetween(1, 500), 5, '0', STR_PAD_LEFT);
        $currentDate = now();
        $futureDateTime = fake()->dateTimeBetween($currentDate, '+1 years');
        
        return [
            'code' => $code,
            'full_name' => fake()->name,
            'email' => fake()->unique()->safeEmail,
            'phone_number' => fake()->unique()->phoneNumber,
            'address' => fake()->city . ' ' . fake()->streetAddress,
            'dob' => fake()->date(),
            'gender' => fake()->randomElement([0,1]),
            'ended_date' => $futureDateTime,
            'is_gues' => 0,
        ];
    }
}
