<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Exercise;

class ExerciseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exercise::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'number' => $this->faker->numberBetween(-10000, 10000),
            'height' => $this->faker->numberBetween(-10000, 10000),
            'uses_cable' => $this->faker->boolean(),
            'url' => $this->faker->url(),
        ];
    }
}
