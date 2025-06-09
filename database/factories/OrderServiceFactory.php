<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderServiceFactory extends Factory
{
    public function definition(): array
    {
        $statusOptions = ['pending', 'in_progress', 'completed', 'cancelled'];
        $priorityOptions = ['low', 'medium', 'high'];
        $paymentOptions = ['unpaid', 'partial', 'paid'];
        $approvalOptions = ['pending', 'approved', 'rejected'];
        $servicesTypes = [
            'installation' => 'Installation',
            'maintenance' => 'Maintenance',
            'repair' => 'Repair',
            'inspection' => 'Inspection',
            'calibration' => 'Calibration',
            'emergency' => 'Emergency Service',
            'consultation' => 'Consultation',
            'preventive' => 'Preventive Maintenance',
            'diagnostic' => 'Diagnostic',
            'other' => 'Other',
        ];

        $startDate = $this->faker->dateTimeBetween('-30 days', 'now');
        $endDate = $this->faker->dateTimeBetween($startDate, '+15 days');

        return [
            'client_id' => Client::factory(),
            'service_type' => $this->faker->randomElement(array_keys($servicesTypes)),
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement($statusOptions),
            'priority' => $this->faker->randomElement($priorityOptions),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'estimated_hours' => $this->faker->randomFloat(2, 1, 40),
            'actual_hours' => $this->faker->randomFloat(2, 1, 50),
            'cost_estimate' => $this->faker->randomFloat(2, 500, 5000),
            'final_cost' => $this->faker->randomFloat(2, 600, 6000),
            'payment_status' => $this->faker->randomElement($paymentOptions),
            'notes' => $this->faker->optional()->sentence,
            'location' => $this->faker->address,
            'equipment_needed' => $this->faker->optional()->sentence,
            'approval_status' => $this->faker->randomElement($approvalOptions),
        ];
    }
}

