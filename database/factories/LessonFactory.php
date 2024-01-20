<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;

class LessonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lesson::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeThisYear();
        
        return [
            'location' => $this->faker->word(),
            'starts_at' => $date,
            'ends_at' => Carbon::parse($date)->addMinutes($this->faker->numberBetween(1, 60)),
            'course_id' => Course::inRandomOrder()->first()->id,
            'teacher_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
