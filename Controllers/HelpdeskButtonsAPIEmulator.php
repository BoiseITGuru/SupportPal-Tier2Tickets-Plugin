<?php

namespace App\Plugins\HelpdeskButtonsAPIEmulator\Controllers;

use App\Modules\Core\Controllers\Plugins\Plugin;
use App\Plugins\HelpdeskButtonsAPIEmulator\Requests\SettingsRequest;
use JsValidator;
use Lang;
use Redirect;
use Session;
use TemplateView;

class HelpdeskButtonsAPIEmulator extends Plugin
{
    /**
     * Plugin identifier.
     */
    const IDENTIFIER = 'HelpdeskButtonsAPIEmulator';

    /**
     * Initialise the plugin.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setIdentifier(self::IDENTIFIER);

        // Register the settings page.
        $this->registerSetting('plugin.helpdeskbuttonsapiemulator.settings');
    }

    /**
     * Get the settings page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function getSettingsPage()
    {
        return TemplateView::other('HelpdeskButtonsAPIEmulator::settings')
            ->with('jsValidator', JsValidator::formRequest(SettingsRequest::class))
            ->with('fields', $this->settings());
    }

    /**
     * Update the settings.
     *
     * @param  SettingsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(SettingsRequest $request)
    {
        $data = $request->all(['setting']);

        // Work through each row of data.
        foreach ($data as $key => $value) {
            if (! empty($value) || $value == 0) {
                $this->addSetting($key, $value);
            }
        }

        // All done, return with a success message.
        Session::flash('success', Lang::get('messages.success_settings'));

        return Redirect::route('plugin.helpdeskbuttonsapiemulator.settings');
    }

    /**
     * Plugins can run an installation routine when they are activated. This will typically include adding default
     * values, initialising database tables and so on.
     *
     * @return boolean
     */
    public function activate()
    {
        // Add permission.
        $attributes = ['view' => true, 'create' => true, 'update' => true, 'delete' => true];
        $this->addPermission('settings', $attributes, 'HelpdeskButtonsAPIEmulator::lang.permission');

        return true;
    }

    /**
     * Deactivating serves as temporarily disabling the plugin, but the files still remain. This function should
     * typically clear any caches and temporary directories.
     *
     * @return boolean
     */
    public function deactivate()
    {
        return true;
    }

    /**
     * When a plugin is uninstalled, it should be completely removed as if it never was there. This function should
     * delete any created database tables, and any files created outside of the plugin directory.
     *
     * @return boolean
     */
    public function uninstall()
    {
        // Remove settings.
        $this->removeSettings();

        // Remove permission.
        $this->removePermission('settings');

        return true;
    }
}
