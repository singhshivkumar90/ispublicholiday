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
        } catch (Exception $exception) {

            return response()->json(['errorCode' => $exception->getCode(), 'errorMessage' => 'Service is unavailable'], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        return response()->json(['data' => $result], Response::HTTP_OK);
    }
}
