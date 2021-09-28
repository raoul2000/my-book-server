<?php

use \thamtech\uuid\helpers\UuidHelper;
use Codeception\Util\Fixtures;
use tests\unit\fixtures\ClientContactFixture;
use \Faker\Factory;

// @see https://forum.yiiframework.com/t/how-to-define-dependable-fixtures-without-using-concrete-values-of-foreign-keys/72887/4

$faker = Factory::create();
$data = [];
for ($i=0; $i < 50; $i++) { 
    $timestamp = $faker->unixTime();
    $data['book-' . $i] = [
        'id'            => UuidHelper::uuid(),
        'title'         => $faker->sentence(3),
        'subtitle'      => $faker->sentence(4),
        'author'        => $faker->name(),
        'isbn'          => 'isbn',
        'is_traveling'  => 0,
        'ping_count'    => 0,
        'created_at'    => $timestamp,
        'updated_at'    => $timestamp
    ];
}

return $data;
