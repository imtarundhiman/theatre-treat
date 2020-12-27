<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(User::where('email', env('INITIAL_USER_EMAIL'))->first()){
            return;
        }

        $user = new User;

        $user->name = env('INITIAL_USER_NAME');
        $user->email = env('INITIAL_USER_EMAIL');
        $user->username = str_slug(env('INITIAL_USER_EMAIL'));
        $user->password = Hash::make('Secret@123');
        $user->is_admin = 1;
        $user->mobile = env('INITIAL_USER_MOBILE');
        $user->save();
    }
}
