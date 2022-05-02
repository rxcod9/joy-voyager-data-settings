<?php

namespace Joy\VoyagerDataSettings\Events;

use Illuminate\Queue\SerializesModels;
use Joy\VoyagerDataSettings\Models\DataSetting;

class DataSettingUpdated
{
    use SerializesModels;

    public $dataSetting;

    public function __construct(DataSetting $dataSetting)
    {
        $this->dataSetting = $dataSetting;
    }
}
