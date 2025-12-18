<?php
/**
 * Copyright (c) Since 2024 InnoShop - All Rights Reserved
 *
 * @link       https://www.sibzard.com
 * @author     InnoShop <team@innoshop.com>
 * @license    https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace InnoShop\RestAPI\FrontApiControllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use InnoShop\Common\Repositories\StateRepo;
use InnoShop\Common\Resources\StateItem;
use InnoShop\Common\Services\StateCityService;

class StateController extends BaseController
{
    /**
     * @var StateCityService
     */
    protected $stateCityService;

    /**
     * @param StateCityService $stateCityService
     */
    public function __construct(StateCityService $stateCityService)
    {
        $this->stateCityService = $stateCityService;
    }

    /**
     * Get all states
     *
     * @param  Request  $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $states = $this->stateCityService->getActiveStates();
        return StateItem::collection($states);
    }

    /**
     * Get cities by state ID
     *
     * @param int $stateId
     * @return \Illuminate\Http\JsonResponse
     */
    public function cities($stateId)
    {
        $cities = $this->stateCityService->getCitiesByState($stateId);
        return response()->json($cities);
    }
}
