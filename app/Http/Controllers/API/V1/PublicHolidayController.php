<?php

namespace App\Http\Controllers\API\V1;

use App\Services\PublicHolidayService;
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
     *
     * @return JsonResponse
     */
    public function check($country): JsonResponse
    {
        $result = $this->publicHolidayService->checkIsHolidayToday($country);

        return response()->json(['data' => $result], Response::HTTP_OK);
    }
}
