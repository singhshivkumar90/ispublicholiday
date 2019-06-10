<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PublicHolidayService
{
    /**
     * Check whether today is public holiday based on country
     *
     * @param $country
     *
     * @return array|bool
     */
    public function checkIsHolidayToday($country)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;

        $apiKey = env('API_KEY');
        $baseUri = "https://calendarific.com/api/v2/holidays?&api_key=$apiKey&country=$country&year=$year&month=$month&day=$day";

        $client = new Client();

        try {
            $result = $client->request('GET', $baseUri);
        } catch (GuzzleException $exception) {

            return $response = [ 'errorCode' => $exception->getCode(), 'errorMessage' => 'Request can not be fulfilled'];
        }

        $holiday = head(json_decode($result->getBody(), true)['response']['holidays']);

        if (empty($holiday)) {
            return false;
        } else {
            return [
                'is_holiday' => true,
                'name' => $holiday['name']
            ];
        }
    }
}
