<?php

use Illuminate\Database\Seeder;

class PerformanceTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        factory(\App\Entities\User::class, 50)->create()->each(function ($user) {
            $user->
        });
        */
        $defaultAccount = entity(\App\Entities\Account::class)->create(['title'=>'Platform Defaults']);
        $defaultUser = entity(\App\Entities\User::class)->create(['account'=>$defaultAccount,'email'=>'admin@god.com']);

        for($i=0; $i<25; $i++) {
            $resultAccount = entity(\App\Entities\Account::class)->create([]);
            $resultUser = entity(\App\Entities\User::class,300)->create(['account'=>$resultAccount]);
            //TODO: create memberships
        }
        //TODO: create parent child accounts with members

    }
}
