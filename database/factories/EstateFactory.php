<?php

namespace Database\Factories;

use App\Models\Bank;
use App\Models\City;
use App\Models\Estate;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Estate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'estateCode' => $this->faker->bothify('?###??##'),
            'name' => $this->faker->word,
            'email' => $this->faker->word,
            'phone' => $this->faker->word,
            'address' => $this->faker->word,
            'city_id' => City::inRandomOrder()->first()->id,
            'state_id' => State::inRandomOrder()->first()->id,
            'bank_id' => Bank::inRandomOrder()->first()->id,
            'accountNumber' => $this->faker->word,
            'accountName' => $this->faker->word,
            'imageName' => "default.jpg",
            'accountVerified' => $this->faker->randomElement([true, false]),
            'alternateEmail' => $this->faker->word,
            'alternatePhone' => $this->faker->word,
            'status' => $this->faker->randomElement(['active', 'pending', 'inactive']),
            'created_by' => User::query()->role('superadministrator')
                ->inRandomOrder()->first()->id,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'deleted_at' => null
        ];
    }
}
