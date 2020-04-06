<?php

use Illuminate\Database\Seeder;
use App\Task;
use Faker\Factory as Faker;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('fr_FR');
        for ($i = 0; $i < 5; $i++) {
            $task = new Task();
            $task->description = $faker->realText(35);
            $task->save();
        }
    }
}
