<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DomainSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$faker = Faker::create();

		foreach (range(1, 100) as $index) {

			$domain = $faker->userName . '-' . $faker->domainName;

			DB::table('domains')->insert([
				'name' => $domain,
				'name_ace' => $domain,
				'original' => "02808f9f-92fc-4cf6-ba13-5e63f3cab54a.by",
				'status' => 'open',
				'price' => rand(3, 1000),
				'customer_id' => 1,
			]);
		}
	}
}
