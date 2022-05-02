<?php

namespace Joy\VoyagerDataSettings\Policies;

use TCG\Voyager\Contracts\User;
use TCG\Voyager\Policies\BasePolicy;

class DataSettingPolicy extends BasePolicy
{
    /**
     * Determine if the given user can browse the model.
     *
     * @param \TCG\Voyager\Contracts\User $user
     * @param                             $model
     *
     * @return bool
     */
    public function browse(User $user, $model)
    {
        return $user->hasPermission('browse_data_settings');
    }

    /**
     * Determine if the given model can be viewed by the user.
     *
     * @param \TCG\Voyager\Contracts\User $user
     * @param                             $model
     *
     * @return bool
     */
    public function read(User $user, $model)
    {
        return $user->hasPermission('read_data_settings');
    }

    /**
     * Determine if the given model can be edited by the user.
     *
     * @param \TCG\Voyager\Contracts\User $user
     * @param                             $model
     *
     * @return bool
     */
    public function edit(User $user, $model)
    {
        return $user->hasPermission('edit_data_settings');
    }

    /**
     * Determine if the given user can create the model.
     *
     * @param \TCG\Voyager\Contracts\User $user
     * @param                             $model
     *
     * @return bool
     */
    public function add(User $user, $model)
    {
        return $user->hasPermission('add_data_settings');
    }

    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param \TCG\Voyager\Contracts\User $user
     * @param                             $model
     *
     * @return bool
     */
    public function delete(User $user, $model)
    {
        return $user->hasPermission('delete_data_settings');
    }
}
