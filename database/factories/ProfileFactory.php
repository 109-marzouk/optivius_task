<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => json_encode([
                "en" => "In English: " . $this->faker->name,
                "ar" => "In Arabic: " . $this->faker->name
            ]),
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->numerify('01#########'),
            'password' => '$2y$10$dK1jpS/zxHozQudEA3aJnu2G4V2Z.uPMrnMP8CkclHuIW77lB2f0a', // 1234
            'verified_email_at' => $this->faker->dateTime(),
            'verified_phone_at' => $this->faker->dateTime(),
        ];
    }
}
