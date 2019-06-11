<?php

namespace App\Http\Controllers\API\V1;

use App\Services\PublicHolidayService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PublicHolidayController extends BaseController
{
    /**
     * @var PublicHolidayService
     */
    public $publicHolidayService;

    /**
     * PublicHolidayService constructor.
     *
     * @param PublicHolidayService $publicHolidayService
     *
     * @return void
     */
    public function __construct(PublicHolidayService $publicHolidayService)
    {
        $this->publicHolidayService = $publicHolidayService;
    }

    /**
     * @param $country
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function check($country): JsonResponse
    {
        try {
            $result = $this->publicHolidayService->checkIsHolidayToday($country);
            return $this->sendResponse($result, Response::HTTP_OK);
        } catch (Exception $exception) {
            return $this->sendResponse($exception->getCode(), Response::HTTP_SERVICE_UNAVAILABLE, 'Service is unavailable');
        }
    }
}
