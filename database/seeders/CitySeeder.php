<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use InnoShop\Common\Models\City;
use InnoShop\Common\Models\State;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Example data - replace with actual cities for each state
        $states = State::all();
        
        $cities = [
            'تهران' => ['تهران', 'اسلامشهر', 'شهریار', 'قدس', 'ملارد'],
            'اصفهان' => ['اصفهان', 'کاشان', 'خمینی شهر', 'شاهین شهر', 'نجف آباد'],
            'فارس' => ['شیراز', 'مرودشت', 'کازرون', 'جهرم', 'فسا'],
            'خراسان رضوی' => ['مشهد', 'نیشابور', 'سبزوار', 'تربت حیدریه', 'قوچان'],
            'آذربایجان شرقی' => ['تبریز', 'مراغه', 'مرند', 'میانه', 'اهر'],
        ];

        foreach ($states as $state) {
            if (isset($cities[$state->name])) {
                foreach ($cities[$state->name] as $cityName) {
                    City::create([
                        'state_id' => $state->id,
                        'name' => $cityName,
                        'active' => true,
                    ]);
                }
            }
        }
    }
}
