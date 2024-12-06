<?php

namespace Database\Factories;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    protected $model = Rating::class;

    public function definition(): array
    {
        return [
            'product_id' => null,
            'rating' => $this->faker->numberBetween(1, 5),
            'name' => $this->faker->name,
            'text' => $this->faker->description,
        ];
    }
}
