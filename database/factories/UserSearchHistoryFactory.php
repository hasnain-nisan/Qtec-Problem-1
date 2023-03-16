<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserSearchHistory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserSearchHistoryFactory extends Factory
{
    /**
     * The name of the model being "factored".
     *
     * @var string
     */
    protected $model = UserSearchHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = rand(1, 5); // Generate random user ID between 1 and 5
        $keyword_id = rand(1, 5);

        return [
            'user_id' => $user_id,
            'search_keyword_id' => $keyword_id,
            'search_engine' => $this->faker->randomElement(['Google', 'Bing', 'Yahoo']),
            'search_time' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'search_results' => $this->faker->paragraph(),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
