<?php namespace Codecycler\OpenVidu\Components;

use Cms\Classes\ComponentBase;
use Codecycler\OpenVidu\Classes\OpenVidu;
use Codecycler\OpenVidu\Models\Settings;

/**
 * Session Component
 */
class Session extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Session Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        //
        $this->addJs('components/session/assets/openvidu.js');
        $this->addJs('components/session/assets/session.js');

        // Temp create a new session every time
        $session = OpenVidu::instance()
            ->createSession($this->page->param('sessionId'));

        // Create a token
        $connection = OpenVidu::instance()
            ->createConnection($session['id']);

        //
        $this->page['connection'] = $connection;
    }

    public function getSessionUrl()
    {
        $server = Settings::get('server');

        return "{$server}";
    }
}
