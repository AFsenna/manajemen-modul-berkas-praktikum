<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class ApiLabinfor
{

    static $key, $client;

    public static function data()
    {
        $key = date("Ymd");
        $client = new Client();
        return ['key' => $key, 'client' => $client];
    }

    public static function loginAdmin($username, $password)
    {
        $getData = self::data();
        $response = $getData['client']->request('POST', 'https://labinformatika.itats.ac.id/api/login-admin', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode(
                [
                    'username' => $username,
                    'password' => $password,
                ]
            )
        ]);

        $decodeResponse = json_decode($response->getBody()->getContents());

        return $decodeResponse;
    }

    public static function loginPraktikan($npm, $password)
    {
        $getData = self::data();
        $response = $getData['client']->request('POST', 'https://labinformatika.itats.ac.id/api/login-praktikan', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode(
                [
                    'npm' => $npm,
                    'password' => $password,
                ]
            )
        ]);

        $decodeResponse = json_decode($response->getBody()->getContents());
        return $decodeResponse;
    }

    public static function getPraktikumAktif()
    {
        $getData = self::data();
        $id = auth()->user()->credential;
        $response = $getData['client']->request('GET', "https://labinformatika.itats.ac.id/api/getPraktikumAktif?id=$id&key=" . $getData['key']);
        $praktikumAktif = json_decode($response->getBody()->getContents());
        return $praktikumAktif;
    }

    public static function getAslabByID($id)
    {
        $getData = self::data();
        $response = $getData['client']->request('GET', 'https://labinformatika.itats.ac.id/api/getAslabByID?id=' . $id . '&key=' . $getData['key']);
        $aslab = json_decode($response->getBody()->getContents());

        return $aslab;
    }

    public static function getPraktikum($id)
    {
        $getData = self::data();
        $response = $getData['client']->request('GET', "https://labinformatika.itats.ac.id/api/getPraktikum?id=$id&key=" . $getData['key']);
        $praktikum = json_decode($response->getBody()->getContents());

        return $praktikum;
    }

    public static function getPraktikumByID($arr)
    {
        $getData = self::data();
        $response = $getData['client']->request('POST', 'https://labinformatika.itats.ac.id/api/getPraktikumByID', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode(
                [
                    'key' =>  $getData['key'],
                    'idPraktikum' => $arr,
                ]
            )
        ]);
        $praktikum = json_decode($response->getBody()->getContents());

        return $praktikum;
    }

    public static function getAllPraktikum()
    {
        $getData = self::data();
        $id = auth()->user()->credential;
        $response = $getData['client']->request('GET', "https://labinformatika.itats.ac.id/api/getAllPraktikum?id=$id&key=" . $getData['key']);
        $praktikumAll = json_decode($response->getBody()->getContents());

        return $praktikumAll;
    }

    public static function getAslabAktif()
    {
        $getData = self::data();
        $id = auth()->user()->credential;
        $response = $getData['client']->request('GET', "https://labinformatika.itats.ac.id/api/getAslabAktif?id=$id&key=" . $getData['key']);
        $aslabAktif = json_decode($response->getBody()->getContents());
        return $aslabAktif;
    }

    public static function getPraktikumAktifAll()
    {
        $getData = self::data();
        $id = auth()->user()->id;
        $response = $getData['client']->request('GET', "https://labinformatika.itats.ac.id/api/getPraktikumAktifAll?key=" . $getData['key']);
        $praktikumAktif = json_decode($response->getBody()->getContents());

        return $praktikumAktif;
    }
}
