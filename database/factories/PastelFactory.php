<?php

namespace Database\Factories;

use App\Models\Pastel;
use Illuminate\Database\Eloquent\Factories\Factory;

class PastelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pastel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'preco' => $this->faker->randomFloat(2, 0, 8)
            //'foto' => $this->faker->image('public/storage/images',640,480, null, false),
        ];
    }
}
