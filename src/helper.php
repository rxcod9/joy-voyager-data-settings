<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Models\DataType;

// if (! function_exists('joyVoyagerDataSettings')) {
//     /**
//      * Helper
//      */
//     function joyVoyagerDataSettings($argument1 = null)
//     {
//         //
//     }
// }

if (!function_exists('dataSetting')) {
    function dataSetting(DataType $dataType, Model $dataTypeContent, $key, $default = null)
    {
        return Voyager::model('DataSettings')->dataSetting($dataType, $dataTypeContent, $key, $default);
    }
}

if (!function_exists('getDataTypeContent')) {
    function getDataTypeContent(DataType $dataType, $id)
    {
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);
            $query = $model->query();

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
                $query = $query->withTrashed();
            }
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $query = $query->{$dataType->scope}();
            }
            $dataTypeContent = call_user_func([$query, 'findOrFail'], $id);
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        return $dataTypeContent;
    }
}
