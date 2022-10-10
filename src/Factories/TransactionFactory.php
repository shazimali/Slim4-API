<?php
namespace App\Factories;

class TransactionFactory {

    public function createTransaction()
    {
        $faker = \Faker\Factory::create();
        return [
            'account_id' => $faker->ean8,
            'amount' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 1, $max =10),
            'user_id' => $faker->numberBetween($min = 5, $max = 11),
            'country_id' => $faker->numberBetween($min = 1, $max = 6)
        ];
    }
}