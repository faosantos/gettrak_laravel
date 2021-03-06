<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Client::class, 50)->create()->each(function($client){
            $client->vehicles()
            ->save(
                factory(App\Vehicle::class)->make()
            );
        });
    }
}
