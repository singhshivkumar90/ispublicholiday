<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;

class PublicHolidayService
{
    /**
     * @param $country
     *
     * @return array
     *
     * @throws GuzzleException
     */
    public function checkIsHolidayToday($country): array
    {
        $uri = $this->getUri($country);

        $client = new Client();

        try {
            $result = $client->request('GET', $uri);
        } catch (RequestException $exception) {
            throw $exception;
        }

        $holiday = head(json_decode($result->getBody(), true)['response']['holidays']);

        $response = $this->getResponse($holiday);

        return $response;
    }

    /**
     * @param $country
     *
     * @return string
     */
    private function getUri($country): string
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;

        $apiKey = config('api.key');
        $baseUri = config('api.base_url');

        $uri = $baseUri . "?&api_key=$apiKey&country=$country&year=$year&month=$month&day=$day";

        return $uri;
    }

    /**
     * @param $holiday
     *
     * @return array
     */
    private function getResponse($holiday): array
    {
        if (empty($holiday)) {
            return ['is_holiday' => false];
        }

        return ['is_holiday' => true, 'name' => $holiday['name']];
    }
}
