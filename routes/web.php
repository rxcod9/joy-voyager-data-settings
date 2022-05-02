<?php

declare(strict_types=1);

use TCG\Voyager\Events\Routing;
use TCG\Voyager\Events\RoutingAdmin;
use TCG\Voyager\Events\RoutingAdminAfter;
use TCG\Voyager\Events\RoutingAfter;
use TCG\Voyager\Facades\Voyager;

/*
|--------------------------------------------------------------------------
| Voyager Routes
|--------------------------------------------------------------------------
|
| This file is where you may override any of the routes that are included
| with Voyager.
|
*/

Route::group(['prefix' => config('joy-voyager-data-settings.admin_prefix', 'admin')], function () {
    Route::group(['as' => 'voyager.'], function () {

        $namespacePrefix = '\\' . config('joy-voyager-data-settings.controllers.namespace') . '\\';

        Route::group(['middleware' => 'admin.user'], function () use ($namespacePrefix) {

            $breadController = $namespacePrefix . 'VoyagerDataSettingsController';

            try {
                foreach (Voyager::model('DataType')::all() as $dataType) {
                    // Settings
                    Route::group([
                        'as'     => $dataType->slug . '.data-settings.',
                        'prefix' => $dataType->slug . '/{id}/settings',
                    ], function () use ($breadController) {
                        Route::get('/', ['uses' => $breadController . '@index',        'as' => 'index']);
                        Route::post('/', ['uses' => $breadController . '@store',        'as' => 'store']);
                        Route::put('/', ['uses' => $breadController . '@update',       'as' => 'update']);
                        Route::delete('{sid}', ['uses' => $breadController . '@delete',       'as' => 'delete']);
                        Route::get('{sid}/move_up', ['uses' => $breadController . '@move_up',      'as' => 'move_up']);
                        Route::get('{sid}/move_down', ['uses' => $breadController . '@move_down',    'as' => 'move_down']);
                        Route::put('{sid}/delete_value', ['uses' => $breadController . '@delete_value', 'as' => 'delete_value']);
                    });
                }
            } catch (\InvalidArgumentException $e) {
                throw new \InvalidArgumentException("Custom routes hasn't been configured because: " . $e->getMessage(), 1);
            } catch (\Exception $e) {
                // do nothing, might just be because table not yet migrated.
            }
        });
    });
});
