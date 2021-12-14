<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Entities\User::class, function (Faker $faker, array $attributes) {
    return [
        'firstName' => $attributes['firstName'] ?? $faker->firstName,
        'lastName' => $attributes['lastName'] ?? $faker->lastName,
        'email' => $attributes['email'] ?? $faker->unique()->safeEmail,
        'owningAccount'=>$attributes['account'],
        'emailVerifiedAt' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'createdAt' => now(),
        'updatedAt' => now(),
    ];
});

$factory->define(\App\Entities\Account::class, function (Faker $faker, array $attributes) {
    $props = [
        'title' => $attributes['title'] ?? $faker->company,
        'isParent' => $attributes['isParent'] ?? false,
        'createdAt' => now(),
        'updatedAt' => now(),
    ];
    if(isset($attributes['parentAccount'])) {
        $props['parentAccount'] = $attributes['parentAccount'];
        $props['isParent'] = false;
    }
    return $props;
});

$factory->define(\App\Entities\Membership::class, function (Faker $fake, array $attributes) {
   $props = [
       'user'=> $attributes['user'],
       'account' => $attributes['account'],
       'createdAt' => now(),
       'updatedAt' => now(),
   ];

   return $props;
});

