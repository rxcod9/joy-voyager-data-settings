<?php

namespace Joy\VoyagerDataSettings\Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Facades\Voyager;

class DataSettingsPermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        Voyager::model('Permission')->generateFor('data_settings');
    }
}
