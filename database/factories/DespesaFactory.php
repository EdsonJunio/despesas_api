<?php

namespace Database\Factories;

use App\Models\Despesa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DespesaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Despesa::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'descricao' => $this->faker->sentence,
            'data' => $this->faker->date(),
            'valor' => $this->faker->randomFloat(2, 1, 1000),
            'usuario_id' => function () {
                return User::factory()->create()->id;
            },
        ];
    }
}
