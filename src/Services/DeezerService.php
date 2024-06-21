<?php

namespace App\Services;

class DeezerService
{
    public function fetchFromDeezer($url)
    {
        header('Access-Control-Allow-Origin: *');
        $response = file_get_contents($url);
        return $response;
    }

    public function getAlbumsUrl(): string
    {
        $api_url = 'https://api.deezer.com/chart/0/albums';
        return $this->fetchFromDeezer($api_url);
    }

    public function getAlbumUrl($id): string
    {
        $api_url = 'https://api.deezer.com/album/' . $id;
        return $this->fetchFromDeezer($api_url);
    }
}

