<?php
/**
 * Copyright (c) Since 2024 InnoShop - All Rights Reserved
 *
 * @link       https://www.sibzard.com
 * @author     InnoShop <team@innoshop.com>
 * @license    https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace InnoShop\Common\Repositories;

use InnoShop\Common\Models\City;
use InnoShop\Common\Repositories\Traits\BaseRepo;

class CityRepo
{
    use BaseRepo;

    /**
     * @var City
     */
    protected static $model = City::class;

    /**
     * Get cities by state ID
     *
     * @param int $stateId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByStateId(int $stateId)
    {
        return self::builder()
            ->where('state_id', $stateId)
            ->orderBy('name')
            ->get();
    }
}
