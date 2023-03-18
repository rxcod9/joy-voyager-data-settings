<?php

namespace Joy\VoyagerDataSettings\Http\Controllers;

use Illuminate\Http\Request;
use Joy\VoyagerDataSettings\Http\Traits\CrudActions;
use Joy\VoyagerCore\Http\Controllers\Controller as TCGVoyagerController;

class VoyagerDataSettingsController extends TCGVoyagerController
{
    use CrudActions;

    protected function getSlug(Request $request)
    {
        if (isset($this->slug)) {
            $slug = $this->slug;
        } else {
            $slug = explode('.', $request->route()->getName())[1];
        }

        return $slug;
    }
}
