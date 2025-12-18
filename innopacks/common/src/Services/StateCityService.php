<?php
/**
 * Copyright (c) Since 2024 InnoShop - All Rights Reserved
 *
 * @link       https://www.sibzard.com
 * @author     InnoShop <team@innoshop.com>
 * @license    https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace InnoShop\Common\Services;

use InnoShop\Common\Models\City;
use InnoShop\Common\Models\State;
use InnoShop\Common\Repositories\CityRepo;
use InnoShop\Common\Repositories\StateRepo;

class StateCityService
{
    /**
     * Get all active states
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveStates()
    {
        return StateRepo::getInstance()->builder([
            'active' => true,
        ])->orderBy('name')->get();
    }

    /**
     * Get cities by state ID
     *
     * @param int $stateId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCitiesByState($stateId)
    {
        return CityRepo::getByStateId($stateId);
    }

    /**
     * Get state with its cities
     *
     * @param int $stateId
     * @return \InnoShop\Common\Models\State|null
     */
    public function getStateWithCities($stateId)
    {
        return State::with(['cities' => function($query) {
            $query->where('active', true)->orderBy('name');
        }])->find($stateId);
    }
}
