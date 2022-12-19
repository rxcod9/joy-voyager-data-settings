<?php

namespace Joy\VoyagerDataSettings\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Facades\Voyager;

trait DeleteValueAction
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

    public function delete_value($id, $sid, Request $request)
    {
        $slug            = $this->getSlug($request);
        $dataType        = Voyager::model('DataType')->whereSlug($slug)->firstOrFail();
        $dataTypeContent = getDataTypeContent($dataType, $id);
        // Check permission
        $this->authorize('delete', $dataTypeContent);

        $setting = Voyager::model('DataSetting')->whereDataId($id)->whereDataSettingTypeId($sid)->firstOrFail();

        // Check permission
        $this->authorize(
            'delete',
            $setting,
        );

        if (isset($setting->id)) {
            // If the type is an image... Then delete it
            if ($setting->dataSettingType->type == 'image') {
                if (Storage::disk(config('voyager.storage.disk'))->exists($setting->value)) {
                    Storage::disk(config('voyager.storage.disk'))->delete($setting->value);
                }
            }
            $setting->value = '';
            $setting->save();
        }

        request()->session()->flash('data_setting_tab', $setting->dataSettingType->group);

        return back()->with([
            'message'    => __('voyager::settings.successfully_removed', ['name' => $setting->dataSettingType->display_name]),
            'alert-type' => 'success',
        ]);
    }
}
