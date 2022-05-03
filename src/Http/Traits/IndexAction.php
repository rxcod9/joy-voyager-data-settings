<?php

namespace Joy\VoyagerDataSettings\Http\Traits;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

trait IndexAction
{
    //***************************************
    //               ____
    //              |  _ \
    //              | |_) |
    //              |  _ <
    //              | |_) |
    //              |____/
    //
    //      DataSettings DataTable our Data Type (B)READ
    //
    //****************************************

    public function index($id, Request $request)
    {
        $slug            = $this->getSlug($request);
        $dataType        = Voyager::model('DataType')->whereSlug($slug)->firstOrFail();
        $dataTypeContent = getDataTypeContent($dataType, $id);
        // Check permission
        $this->authorize('browse', $dataTypeContent);

        // Check permission
        $this->authorize(
            'browse',
            Voyager::model('DataSetting'),
        );

        $types        = Voyager::model('DataSettingType')->whereDataTypeSlug($slug)->orderBy('order', 'ASC')->get();
        $dataSettings = Voyager::model('DataSetting')->whereDataId($id)->get();

        $settingTypes                                        = [];
        $settings                                            = [];
        $settingTypes[__('voyager::settings.group_general')] = [];
        $settings[__('voyager::settings.group_general')]     = [];
        foreach ($types as $d) {
            $s = $dataSettings->where('data_setting_type_id', $d->id)->first();
            if ($d->group == '' || $d->group == __('voyager::settings.group_general')) {
                $settingTypes[__('voyager::settings.group_general')][] = $d;
                $settings[__('voyager::settings.group_general')][]     = $s;
            } else {
                $settingTypes[$d->group][] = $d;
                $settings[$d->group][]     = $s;
            }
        }
        if (count($settingTypes[__('voyager::settings.group_general')]) == 0) {
            unset($settingTypes[__('voyager::settings.group_general')]);
        }
        if (count($settings[__('voyager::settings.group_general')]) == 0) {
            unset($settings[__('voyager::settings.group_general')]);
        }

        $groups_data = Voyager::model('DataSettingType')->whereDataTypeSlug($slug)->select('group')->distinct()->get();
        $groups      = [];
        foreach ($groups_data as $group) {
            if ($group->group != '') {
                $groups[] = $group->group;
            }
        }

        $active = (request()->session()->has('data_setting_tab')) ? request()->session()->get('data_setting_tab') : old('data_setting_tab', key($settings));

        return Voyager::view(
            'joy-voyager-data-settings::settings.index',
            compact('settingTypes', 'settings', 'groups', 'active', 'id', 'dataType', 'dataTypeContent')
        );
    }
}
