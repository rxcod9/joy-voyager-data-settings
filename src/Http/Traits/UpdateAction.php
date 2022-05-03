<?php

namespace Joy\VoyagerDataSettings\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;

trait UpdateAction
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

    public function update($id, Request $request)
    {
        $slug            = $this->getSlug($request);
        $dataType        = Voyager::model('DataType')->whereSlug($slug)->firstOrFail();
        $dataTypeContent = getDataTypeContent($dataType, $id);
        // Check permission
        $this->authorize('edit', $dataTypeContent);

        // Check permission
        $this->authorize(
            'edit',
            Voyager::model('DataSetting'),
        );

        $settingTypes = Voyager::model('DataSettingType')->whereDataTypeSlug($slug)->get();
        $settings     = Voyager::model('DataSetting')->whereDataId($id)->get();

        foreach ($settingTypes as $settingType) {
            $content = $this->getContentBasedOnType($request, 'data_settings', (object) [
                'type'  => $settingType->type,
                'field' => str_replace('.', '_', $settingType->key),
                'group' => $settingType->group,
            ], $settingType->details);

            if ($settingType->type == 'image' && $content == null) {
                continue;
            }

            if ($settingType->type == 'file' && $content == null) {
                continue;
            }

            $key = preg_replace('/^' . Str::slug($settingType->group) . './i', '', $settingType->key);

            $settingType->group = $request->input(str_replace('.', '_', $settingType->key) . '_group');
            $settingType->key   = implode('.', [Str::slug($settingType->group), $key]);
            // $settingType->value = $content;
            $settingType->data_type_slug = $dataType->slug;
            $settingType->save();

            $setting = Voyager::model('DataSetting')->firstOrNew([
                'data_id'              => $id,
                'data_setting_type_id' => $settingType->id,
            ]);
            $setting->value = $content;
            $setting->save();
        }

        request()->flashOnly('data_setting_tab');

        return back()->with([
            'message'    => __('voyager::settings.successfully_saved'),
            'alert-type' => 'success',
        ]);
    }
}
