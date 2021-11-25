<?php

namespace Database\Factories;

use App\Models\Khoa;
use Faker\Generator as faker;

$factory->define(App\Khoa::class, function (faker $faker) {
    return [
         'MaKhoa' => $faker->MaKhoa,
        'TenKhoa' => $faker->TenKhoa,
    ];
});

