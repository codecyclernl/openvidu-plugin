<?php namespace Codecycler\OpenVidu\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'codecycler_openvidu_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}
