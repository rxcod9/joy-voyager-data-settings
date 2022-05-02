<?php

namespace Joy\VoyagerDataSettings\Actions;

use Illuminate\Http\Request;
use TCG\Voyager\Actions\AbstractAction;

class DataSettingsAction extends AbstractAction
{
    public function getTitle()
    {
        return __('joy-voyager-data-settings::generic.data_settings_btn');
    }

    public function getIcon()
    {
        return 'voyager-settings';
    }

    public function getPolicy()
    {
        return 'browse';
    }

    public function getAttributes()
    {
        return [
            'id'     => 'data_settings_btn',
            'class'  => 'btn btn-sm btn-primary pull-right',
            'target' => '_blank',
        ];
    }

    public function getDefaultRoute()
    {
        return route('voyager.' . $this->dataType->slug . '.data-settings.index', $this->data->getKey());
    }

    public function shouldActionDisplayOnDataType()
    {
        return config('joy-voyager-data-type-settings.enabled', true) !== false
            && isInPatterns(
                $this->dataType->slug,
                config('joy-voyager-data-type-settings.allowed_slugs', ['*'])
            )
            && !isInPatterns(
                $this->dataType->slug,
                config('joy-voyager-data-type-settings.not_allowed_slugs', [])
            );
    }

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
