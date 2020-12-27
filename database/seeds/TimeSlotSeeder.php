<?php

use Illuminate\Database\Seeder;
use App\Models\TimeSlot;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!TimeSlot::count()){
            TimeSlot::insert([
                [
                    'time_slot' => '9am-12pm'
                ],[
                    'time_slot' => '3pm-6pm'
                ],[
                    'time_slot' => '6pm-9pm'
                ]
            ]);
        }
    }
}
