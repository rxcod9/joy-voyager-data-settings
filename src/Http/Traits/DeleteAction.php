<?php

namespace Joy\VoyagerDataSettings\Http\Traits;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

trait DeleteAction
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

    public function delete($id, $sid, Request $request)
    {
        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->whereSlug($slug)->firstOrFail();
        $dataTypeContent = getDataTypeContent($dataType, $id);
        // Check permission
        $this->authorize('delete', $dataTypeContent);

        // Check permission
        $this->authorize(
            'delete',
            Voyager::model('DataSetting'),
        );

        $settingType = Voyager::model('DataSettingType')->whereKey((int) $sid)->firstOrFail();

        Voyager::model('DataSettingType')->destroy($sid);
        Voyager::model('DataSetting')->whereDataId($id)->whereDataSettingTypeId($sid)->delete();

        request()->session()->flash('data_setting_tab', $settingType->group);

        return back()->with([
            'message'    => __('voyager::settings.successfully_deleted'),
            'alert-type' => 'success',
        ]);
    }
}
