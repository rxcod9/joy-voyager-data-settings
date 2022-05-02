<?php

namespace Joy\VoyagerDataSettings\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

trait StoreAction
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

    public function store($id, Request $request)
    {
        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->whereSlug($slug)->firstOrFail();
        $dataTypeContent = getDataTypeContent($dataType, $id);
        // Check permission
        $this->authorize('add', $dataTypeContent);

        // Check permission
        $this->authorize(
            'add',
            Voyager::model('DataSetting'),
        );

        $key       = implode('.', [Str::slug($request->input('group')), $request->input('key')]);
        $key_check = Voyager::model('DataSettingType')->whereDataTypeSlug($slug)->where('key', $key)->get()->count();

        if ($key_check > 0) {
            return back()->with([
                'message'    => __('voyager::settings.key_already_exists', ['key' => $key]),
                'alert-type' => 'error',
            ]);
        }

        $lastSetting = Voyager::model('DataSettingType')->whereDataTypeSlug($slug)->orderBy('order', 'DESC')->first();

        if (is_null($lastSetting)) {
            $order = 0;
        } else {
            $order = intval($lastSetting->order) + 1;
        }

        $request->merge(['data_type_slug' => $dataType->slug]);
        $request->merge(['order' => $order]);
        $request->merge(['value' => null]);
        $request->merge(['key' => $key]);

        $dataSettingType = Voyager::model('DataSettingType')->create($request->except(['data_setting_tab', 'value']));

        Voyager::model('DataSetting')->create([
            'data_id'              => $id,
            'data_setting_type_id' => $dataSettingType->id,
            'value'                => null,
        ]);

        request()->flashOnly('data_setting_tab');

        return back()->with([
            'message'    => __('voyager::settings.successfully_created'),
            'alert-type' => 'success',
        ]);
    }
}
