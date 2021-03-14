<?php

declare(strict_types=1);

namespace App\Service;

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyService
{
    public function test()
    {

        $session = new Session(
            '72773783c84c42619692ad0dadb4c63c',
            'a8718b3730924d5f80fcc4f72bdc8071',
            '127.0.0.1:8000'
        );

        $api = new SpotifyWebAPI();

        if (isset($_GET['code'])) {
            $session->requestAccessToken($_GET['code']);
            $api->setAccessToken($session->getAccessToken());

            dump($api->me());
        } else {
            $options = [
                'scope' => [
                    'user-read-email',
                ],
            ];

            header('Location: ' . $session->getAuthorizeUrl($options));
            die();
        }

    }
}
