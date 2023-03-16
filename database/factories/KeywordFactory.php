<?php

namespace Database\Factories;

use App\Models\Keyword;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class KeywordFactory extends Factory
{
    /**
     * The name of the model being "factored".
     *
     * @var string
     */
    protected $model = Keyword::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'keyword' => $this->faker->word(),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
