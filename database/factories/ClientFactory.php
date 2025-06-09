<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'mobile' => $this->faker->phoneNumber,
            'document' => $this->faker->numerify('###.###.###-##'),
            'type' => $this->faker->randomElement(['individual', 'company']),
            'zip_code' => $this->faker->postcode,
            'address' => $this->faker->streetAddress,
            'number' => $this->faker->buildingNumber,
            'complement' => $this->faker->optional()->secondaryAddress,
            'neighborhood' => $this->faker->word,
            'city' => $this->faker->city,
            'state' => $this->faker->stateAbbr,
            'active' => $this->faker->boolean,
            'notes' => $this->faker->optional()->sentence,
            'photo' => null, // ou use um caminho falso tipo: 'photo.jpg'
        ];
    }
}
