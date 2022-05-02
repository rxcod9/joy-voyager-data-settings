<?php

namespace Joy\VoyagerDataSettings\Models;

use Illuminate\Database\Eloquent\Model;
use Joy\VoyagerDataSettings\Events\DataSettingUpdated;
use TCG\Voyager\Facades\Voyager;

class DataSetting extends Model
{
    protected $table = 'data_settings';

    protected $guarded = [];

    public $timestamps = false;

    protected $dispatchesEvents = [
        'updating' => DataSettingUpdated::class,
    ];

    public function dataSettingType()
    {
        return $this->belongsTo(Voyager::modelClass('DataSettingType'));
    }
}
