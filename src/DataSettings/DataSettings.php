<?php

namespace Joy\VoyagerDataSettings\DataSettings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Models\DataType;

class DataSettings
{
    public static $setting_cache = null;

    /**
     * Get data setting
     */
    public static function dataSetting(DataType $dataType, Model $dataTypeContent, $key, $default = null)
    {
        $globalCache = config('voyager.settings.cache', false);

        if ($globalCache && Cache::tags('data-settings-' . $dataType->slug . '-' . $dataTypeContent->getKey())->has($key)) {
            return Cache::tags('data-settings-' . $dataType->slug . '-' . $dataTypeContent->getKey())->get($key);
        }

        if (
            self::$setting_cache === null ||
            (self::$setting_cache[$dataType->slug] ?? null) === null ||
            (self::$setting_cache[$dataType->slug][$dataTypeContent->getKey()] ?? null) === null
        ) {
            if ($globalCache) {
                // A key is requested that is not in the cache
                // this is a good opportunity to update all keys
                // albeit not strictly necessary
                Cache::tags('data-settings-' . $dataType->slug . '-' . $dataTypeContent->getKey())->flush();
            }

            $settingTypes = Voyager::model('DataSettingType')->whereDataTypeSlug($dataType->slug)->orderBy('order')->get();
            $settings     = Voyager::model('DataSetting')->whereDataId($dataTypeContent->getKey())->get();
            foreach ($settingTypes as $settingType) {
                $setting                                  = $settings->where('data_setting_type_id', $settingType->id)->first();
                $keys                                     = explode('.', $settingType->key);
                @self::$setting_cache[$settingType->data_type_slug][$dataTypeContent->getKey()][$keys[0]][$keys[1]] = optional($setting)->value ?? null;

                if ($globalCache) {
                    Cache::tags('data-settings-' . $dataType->slug . '-' . $dataTypeContent->getKey())->forever($settingType->key, $settingType->value);
                }
            }
        }

        $parts = explode('.', $key);

        if (count($parts) == 2) {
            return @self::$setting_cache[$dataType->slug][$dataTypeContent->getKey()][$parts[0]][$parts[1]] ?: $default;
        } else {
            return @self::$setting_cache[$dataType->slug][$dataTypeContent->getKey()][$parts[0]] ?: $default;
        }
    }
}
