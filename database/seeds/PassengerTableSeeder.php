<?php

use Illuminate\Database\Seeder;

class PassengerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        
        for ($i=0; $i < 500; $i++) { 
            DB::table('passengers')->insert([
               'name' => $faker->name,
               'email' => $faker->email,
               'contact_no' => $faker->e164PhoneNumber,
               'customer_id' => $faker->numberBetween($min = 1, $max = 100),
               'created_at' =>$faker->dateTimeBetween($startDate = '-0 years', $endDate = 'now', $timezone = null) ,
               'pickup' => $faker->word,
               'dropoff' => $faker->word,
               'institution'=>$faker->word,
               'remarks' => $faker->sentence,
               'campaign_id' => $faker->numberBetween($min = 1, $max = 3),
               'updated_at' => $faker->dateTimeBetween($startDate = '-0 years', $endDate = 'now', $timezone = null)
           ]);
        }

    }
}
