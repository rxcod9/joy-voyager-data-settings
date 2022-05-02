<?php

namespace Joy\VoyagerDataSettings\Http\Traits;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

trait MoveUpAction
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

    public function move_up($id, $sid, Request $request)
    {
        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->whereSlug($slug)->firstOrFail();
        $dataTypeContent = getDataTypeContent($dataType, $id);
        // Check permission
        $this->authorize('edit', $dataTypeContent);

        // Check permission
        $this->authorize(
            'edit',
            Voyager::model('DataSetting'),
        );

        $setting     = Voyager::model('DataSetting')->whereDataId((int) $id)->whereDataSettingTypeId((int) $sid)->firstOrFail();
        $settingType = $setting->dataSettingType;

        // Check permission
        $this->authorize(
            'browse',
            $setting,
        );

        $swapOrder           = $settingType->order;
        $previousSettingType = Voyager::model('DataSettingType')
            ->whereDataTypeSlug($slug)
            ->where('order', '<', $swapOrder)
            ->where('group', $setting->dataSettingType->group)
            ->orderBy('order', 'DESC')->first();
        $data = [
            'message'    => __('voyager::settings.already_at_top'),
            'alert-type' => 'error',
        ];

        if (isset($previousSettingType->order)) {
            $settingType->order = $previousSettingType->order;
            $settingType->save();
            $previousSettingType->order = $swapOrder;
            $previousSettingType->save();

            $data = [
                'message'    => __('voyager::settings.moved_order_up', ['name' => $settingType->display_name]),
                'alert-type' => 'success',
            ];
        }

        request()->session()->flash('data_setting_tab', $settingType->group);

        return back()->with($data);
    }
}
