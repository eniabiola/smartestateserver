<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'surname' => $this->faker->lastName,
        'othernames' => $this->faker->firstName,
        'phone' => $this->faker->e164PhoneNumber,
        'gender' => $this->faker->randomElement(['male', 'female']),
        'email' => $this->faker->email,
        'email_verified_at' => $this->faker->date('Y-m-d H:i:s'),
        'password' => bcrypt('password'),
        'remember_token' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
