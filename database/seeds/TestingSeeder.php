<?php

use Illuminate\Database\Seeder;

class TestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Provider::class, 10)->create()->each(
    		function($provider) {
		        factory(App\ProviderService::class)->create(['provider_id' => $provider->id]);
    		}
    	);
    }
}
