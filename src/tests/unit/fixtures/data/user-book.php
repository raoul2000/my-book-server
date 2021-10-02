<?php

use Codeception\Util\Fixtures;
use tests\unit\fixtures\UserFixture;
use tests\unit\fixtures\BookFixture;
use \Faker\Factory;

// @see https://forum.yiiframework.com/t/how-to-define-dependable-fixtures-without-using-concrete-values-of-foreign-keys/72887/4

$faker = Factory::create();
$users = Fixtures::get(UserFixture::class);
$books = Fixtures::get(BookFixture::class);


$user_id = $users['bob']['id'];

$timestamp = $faker->unixTime();

$data = [];
for ($i=0; $i < 500; $i++) { 

    $book_id = $books['book-' . $i]['id'];

    $data['ub-' . $i] = [
        'user_id'       => $user_id,
        'book_id'       => $book_id,
        'read_status'   => 1,
        'rate'          => 3,
        'created_at'    => $timestamp,
        'updated_at'    => $timestamp        
    ];
}
return $data;
