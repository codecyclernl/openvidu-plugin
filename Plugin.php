<?php namespace Codecycler\OpenVidu;

use Backend;
use System\Classes\PluginBase;

/**
 * OpenVidu Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'OpenVidu',
            'description' => 'No description provided yet...',
            'author'      => 'Codecycler',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Codecycler\OpenVidu\Components\Session' => 'openViduSession',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'codecycler.openvidu.access_settings' => [
                'tab' => 'OpenVidu',
                'label' => 'Access settings'
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'OpenVidu Settings',
                'description' => 'Manage OpenVidu based settings.',
                'category'    => 'system::lang.system.categories.system',
                'icon'        => 'icon-cog',
                'class'       => 'Codecycler\OpenVidu\Models\Settings',
                'order'       => 500,
                'keywords'    => 'openvidu',
                'permissions' => ['codecycler.openvidu.access_settings']
            ]
        ];
    }
}
