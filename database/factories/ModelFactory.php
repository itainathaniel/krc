<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Member::class, function (Faker\Generator $faker) {
	return [
		'knesset_id' => $faker->numberBetween(1,9999),
		'first_name' => $faker->firstName,
		'first_name_english' => $faker->firstName,
		'last_name' => $faker->lastName,
		'last_name_english' => $faker->lastName,
		'gender' => $faker->randomElement(['male', 'female']),
		'image' => $faker->imageUrl(200, 200, 'cats'),
		'birth_date' => $faker->date(),
		'present' => 0
	];
});

$factory->define(App\VisitLog::class, function (Faker\Generator $faker) {
	return [
		'present' => 0,
		'processed' => 0,
		'member_id' => function () {
            return factory(App\Member::class)->create()->id;
        }
	];
});

$factory->state(App\VisitLog::class, 'outside', function (Faker\Generator $faker) {
	return [
		'present' => 0,
	];
});

$factory->state(App\VisitLog::class, 'inside', function (Faker\Generator $faker) {
	return [
		'present' => 1,
	];
});

