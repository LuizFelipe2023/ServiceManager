<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TechnicianFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'mobile' => $this->faker->phoneNumber,
            'specialization' => $this->faker->randomElement(['Electrician', 'Plumber', 'Mechanic', 'IT']),
            'certification_number' => $this->faker->unique()->numerify('CERT-#####'),
            'certification_expiry' => $this->faker->dateTimeBetween('+1 year', '+5 years'),
            'hourly_rate' => $this->faker->randomFloat(2, 50, 200),
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'zip_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'hire_date' => $this->faker->dateTimeBetween('-10 years', '-1 year'),
            'termination_date' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
            'emergency_contact_name' => $this->faker->name,
            'emergency_contact_phone' => $this->faker->phoneNumber,
            'notes' => $this->faker->optional()->sentence,
            'active' => $this->faker->boolean(90),
            'photo_path' => null, 
        ];
    }
}


