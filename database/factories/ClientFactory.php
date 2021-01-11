<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'telefone' => $this->faker->phoneNumber,
            'data_de_nascimento' => $this->faker->date('Y-m-d', 'now'),
            'endereco' => $this->faker->streetAddress,
            'complemento' => $this->faker->secondaryAddress,
            'bairro' => $this->faker->state,
            'cep' => $this->faker->postcode
        ];
    }
}
