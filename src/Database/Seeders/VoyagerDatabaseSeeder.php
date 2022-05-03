<?php

namespace Joy\VoyagerDataSettings\Database\Seeders;

use Database\Seeders\PermissionRoleTableSeeder;
use Illuminate\Database\Seeder;

class VoyagerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DataSettingsPermissionsTableSeeder::class,
            PermissionRoleTableSeeder::class,
        ]);
    }
}
