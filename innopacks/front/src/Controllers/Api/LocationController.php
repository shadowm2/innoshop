<?php

namespace InnoShop\Front\Controllers\Api;

use InnoShop\Front\Controllers\Controller;
use InnoShop\Common\Models\City;
use InnoShop\Common\Models\Country;
use InnoShop\Common\Models\State;

class LocationController extends Controller
{
    /**
     * Get all countries
     */
    public function countries()
    {
        $countries = Country::where('active', 1)
            ->orderBy('name')
            ->get(['id', 'name', 'code']);
        return response()->json($countries);
    }

    /**
     * Get states by country code
     */
    public function states($countryCode)
    {
        $country = Country::where('code', $countryCode)->first();
        if (!$country) {
            return response()->json([]);
        }

        $states = State::where('country_id', $country->id)
            ->where('active', 1)
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return response()->json($states);
    }

    /**
     * Get cities by state code
     */
    public function cities($stateCode)
    {
        // Find state by code, country code (IR), and active status
        $state = State::where('code', $stateCode)
                     ->where('country_code', 'IR')  // Added country code filter
                     ->where('active', 1)
                     ->first();

        // Log state lookup
        \Log::debug('State lookup:', [
            'state_code' => $stateCode,
            'found_state' => $state ? [
                'id' => $state->id,
                'name' => $state->name,
                'code' => $state->code,
                'country_code' => $state->country_code
            ] : null
        ]);

        if (!$state) {
            return response()->json([]);
        }

        $cities = City::where('state_id', $state->id)
            ->where('active', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        // Log cities query
        \Log::debug('Cities query result:', [
            'state_code' => $stateCode,
            'state_id' => $state->id,
            'cities_count' => $cities->count(),
            'first_few_cities' => $cities->take(3)
        ]);

        return response()->json($cities);
    }
}