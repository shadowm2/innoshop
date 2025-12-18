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
use InnoShop\Common\Repositories\CityRepo;
use InnoShop\Common\Resources\CityItem;

class CityController extends BaseController
{
    /**
     * Get cities by state ID
     *
     * @param  Request  $request
     * @param  int  $stateId
     * @return AnonymousResourceCollection
     */
    public function getByState(Request $request, int $stateId): AnonymousResourceCollection
    {
        $cities = CityRepo::getByStateId($stateId);
        
        return CityItem::collection($cities);
    }
}
