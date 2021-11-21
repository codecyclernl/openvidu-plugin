<?php namespace Codecycler\OpenVidu\Classes;

use GuzzleHttp\Client;
use Codecycler\OpenVidu\Models\Settings;
use GuzzleHttp\Exception\RequestException;
use October\Rain\Support\Traits\Singleton;

class OpenVidu
{
    use Singleton;

    protected $baseUrl;

    protected $secret;

    protected $client;

    public function init()
    {
        $this->baseUrl = Settings::get('server');
        $this->secret = Settings::get('secret');

        $this->token = base64_encode("OPENVIDUAPP:{$this->secret}");

        $this->client = new Client([
            'base_uri' => "$this->baseUrl/openvidu/api/",
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode("OPENVIDUAPP:{$this->secret}"),
            ],
        ]);
    }

    public function getSessions()
    {
        return $this->get('sessions');
    }

    public function createSession($customId = null)
    {
        $config = null;
        $session = null;

        if ($customId) {
            $config = [
                'customSessionId' => $customId,
            ];

            // First check if the session already exists
            try {
                return $this->get("sessions/{$customId}");
            } catch (RequestException $exception) {
                return $this->post('sessions', $config);
            }
        }
    }

    public function createConnection($sessionId)
    {
        $config = [
            'type' => 'WEBRTC',
            'data' => '',
            'role' => 'PUBLISHER',
        ];

        return $this->post("sessions/{$sessionId}/connection", $config);
    }

    public function post($url, $config)
    {
        $response = $this->client->post($url, [
            'json' => $config,
        ], [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function get($url)
    {
        $response = $this->client->get($url);

        return json_decode($response->getBody(), true);
    }
}
