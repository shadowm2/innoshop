<?php

namespace InnoShop\Common\Support;

use Illuminate\Support\Collection;

class OpenGraph
{
    public static function getRenderedMetaTags(): Collection
    {
        return self::getTags()->map(function ($tag) {
            return sprintf('<meta property="%s" content="%s">', $tag['title'], $tag['value']);
        });
    }

    public static function renderMetaTags(): string
    {
        return static::getRenderedMetaTags()->join("\n  ");
    }

    public static function getTags(): Collection
    {
        $tags = [
            [
                'title' => 'locale',
                'value' => env('WEBSITE_LOCALE', 'fa_IR'),
            ],
            [
                'title' => 'type',
                'value' => 'website',
            ],
            [
                'title' => 'title',
                'value' => system_setting_locale('meta_title'),
            ],
            [
                'title' => 'description',
                'value' => system_setting_locale('meta_description'),
            ], [
                'title' => 'url',
                'value' => front_route('home.index'),
            ],
            [
                'title' => 'site_name',
                'value' => config('app.name'),
            ],
            [
                'title' => 'image',
                'value' => image_origin(system_setting('front_logo', 'images/logo.svg')),
            ],
            [
                'title' => 'image:secure_url',
                'value' => image_origin(system_setting('front_logo', 'images/logo.svg')),
            ],
        ];

        return collect($tags)->map(function ($tag) {
            return [
                ...$tag,
                'title' => 'og:'.$tag['title'],
            ];
        });
    }
}

// meta property="og:locale" content="fa_IR" />
// <meta property="og:type" content="website" />
// <meta property="og:title" content="مستر چرم؛ فروشگاه آنلاین کیف و کفش چرم طبیعی مردانه و زنانه" />
// <meta property="og:description" content="در مسترچرم می توانید بیشترین تنوع کیف زنانه، کیف مردانه، کفش زنانه، کفش مردانه و انواع هدایا و ست چرم طبیعی با قیمت مناسب به صورت نقد و اقساط با ارسال فوری خریداری نمایید." />
// <meta property="og:url" content="https://mrcharm.ir/" />
// <meta property="og:site_name" content="مستر چرم" />
// <meta property="og:updated_time" content="2025-12-24T14:32:40+03:30" />
// <meta property="og:image" content="https://mrcharm.ir/wp-content/uploads/2025/08/favicon-new.webp" />
// <meta property="og:image:secure_url" content="https://mrcharm.ir/wp-content/uploads/2025/08/favicon-new.webp" />
// <meta property="og:image:width" content="512" />
// <meta property="og:image:height" content="512" />
// <meta property="og:image:alt" content="مسترچرم" />
// <meta property="og:image:type" content="image/webp" />
