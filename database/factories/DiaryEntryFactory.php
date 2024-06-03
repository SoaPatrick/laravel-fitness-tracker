<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\DiaryEntry;
use App\Models\Exercise;

class DiaryEntryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DiaryEntry::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'weight' => $this->faker->numberBetween(-10000, 10000),
            'exercise_id' => Exercise::factory(),
        ];
    }
}
