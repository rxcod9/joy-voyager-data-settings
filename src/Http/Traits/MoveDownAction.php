<?php

namespace Joy\VoyagerDataSettings\Http\Traits;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

trait MoveDownAction
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

    public function move_down($id, $sid, Request $request)
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

        $swapOrder = $settingType->order;

        $previousSettingType = Voyager::model('DataSettingType')
            ->whereDataTypeSlug($slug)
            ->where('order', '>', $swapOrder)
            ->where('group', $settingType->group)
            ->orderBy('order', 'ASC')->first();
        $data = [
            'message'    => __('voyager::settings.already_at_bottom'),
            'alert-type' => 'error',
        ];

        if (isset($previousSettingType->order)) {
            $settingType->order = $previousSettingType->order;
            $settingType->save();
            $previousSettingType->order = $swapOrder;
            $previousSettingType->save();

            $data = [
                'message'    => __('voyager::settings.moved_order_down', ['name' => $setting->display_name]),
                'alert-type' => 'success',
            ];
        }

        request()->session()->flash('data_setting_tab', $settingType->group);

        return back()->with($data);
    }
}
