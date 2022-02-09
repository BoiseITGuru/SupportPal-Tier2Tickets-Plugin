<?php

$router->get('settings', [
    'can'  => 'view.helpdeskbuttonsapiemulator_settings',
    'as'   => 'plugin.helpdeskbuttonsapiemulator.settings',
    'uses' => 'App\Plugins\HelpdeskButtonsAPIEmulator\Controllers\HelpdeskButtonsAPIEmulator@getSettingsPage'
]);

$router->post('settings', [
    'can'  => 'update.helpdeskbuttonsapiemulator_settings',
    'as'   => 'plugin.helpdeskbuttonsapiemulator.settings.update',
    'uses' => 'App\Plugins\HelpdeskButtonsAPIEmulator\Controllers\HelpdeskButtonsAPIEmulator@updateSettings'
]);
