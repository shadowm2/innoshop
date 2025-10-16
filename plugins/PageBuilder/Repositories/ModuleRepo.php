<?php
/**
 * Copyright (c) Since 2024 InnoShop - All Rights Reserved
 *
 * @link       https://www.innoshop.com
 * @author     InnoShop <team@innoshop.com>
 * @license    https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace Plugin\PageBuilder\Repositories;

class ModuleRepo
{
    /**
     * Get all available module configurations
     */
    public static function getModules(): array
    {
        return [
            // ===== Core Modules (Most Important, Most Commonly Used) =====
            [
                'title'   => trans('PageBuilder::modules.slideshow'),
                'code'    => 'slideshow',
                'icon'    => '<i class="bi bi-images"></i>',
                'content' => [
                    'images' => [
                        [
                            'image' => 'images/demo/banner/banner-1-en.jpg',
                            'show'  => true,
                            'link'  => [
                                'type'  => 'product',
                                'value' => '',
                            ],
                        ],
                        [
                            'image' => [
                                'zh_cn' => 'images/demo/banner/banner-1-cn.jpg',
                                'en'    => 'images/demo/banner/banner-1-en.jpg',
                            ],
                            'show' => false,
                            'link' => [
                                'type'  => 'product',
                                'value' => '',
                            ],
                        ],
                        [
                            'image' => [
                                'zh_cn' => 'images/demo/banner/banner-2-cn.jpg',
                                'en'    => 'images/demo/banner/banner-2-en.jpg',
                            ],
                            'show' => false,
                            'link' => [
                                'type'  => 'product',
                                'value' => '',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title'   => trans('PageBuilder::modules.custom_products'),
                'code'    => 'custom-products',
                'icon'    => '<i class="bi bi-box"></i>',
                'content' => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'floor'    => self::languagesFill(''),
                    'products' => [],
                    'title'    => self::languagesFill('محصولات پیشنهادی'),
                    'subtitle' => self::languagesFill(''),
                    'columns'  => 4,
                ],
            ],
            [
                'title'   => trans('PageBuilder::modules.category_products'),
                'code'    => 'category-products',
                'icon'    => '<i class="bi bi-collection"></i>',
                'content' => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'limit'         => 8,
                    'order'         => 'asc',
                    'category_id'   => '',
                    'category_name' => '',
                    'sort'          => 'sales',
                    'floor'         => self::languagesFill(''),
                    'products'      => [],
                    'title'         => self::languagesFill('محصولات دسته‌بندی'),
                    'columns'       => 4,
                ],
            ],
            [
                'title'   => trans('PageBuilder::modules.latest_products'),
                'code'    => 'latest-products',
                'icon'    => '<i class="bi bi-clock"></i>',
                'content' => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'limit'    => 8,
                    'floor'    => self::languagesFill(''),
                    'products' => [],
                    'title'    => self::languagesFill('تازه موجود شده'),
                ],
            ],
            [
                'title'   => trans('PageBuilder::modules.rich_text'),
                'code'    => 'rich-text',
                'icon'    => '<i class="bi bi-file-richtext"></i>',
                'content' => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'title'    => self::languagesFill(''),
                    'subtitle' => self::languagesFill(''),
                    'content'  => self::languagesFill(''),
                ],
            ],

            // ===== Important Modules (Commonly Used) =====
            [
                'title'   => trans('PageBuilder::modules.single_image'),
                'code'    => 'single-image',
                'icon'    => '<i class="bi bi-image"></i>',
                'content' => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'images' => [
                        [
                            'image' => 'images/demo/banner/banner-2-en.jpg',
                            'show'  => true,
                            'link'  => [
                                'type'  => 'product',
                                'value' => '',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title'   => trans('PageBuilder::modules.four_image'),
                'code'    => 'four-image',
                'icon'    => '<i class="bi bi-layout-text-window-reverse"></i>',
                'content' => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'title'    => self::languagesFill('چیدمان افقی چهار تصویر'),
                    'subtitle' => self::languagesFill('شما می‌توانید زیرعنوان تنظیم کنید'),
                    'images'   => [
                        [
                            'image'       => '',
                            'description' => self::languagesFill('اینجا توضیحات متنی است'),
                            'show'        => true,
                            'link'        => [
                                'type'  => 'product',
                                'value' => '',
                            ],
                        ],
                        [
                            'image'       => '',
                            'description' => self::languagesFill('اینجا توضیحات متنی است'),
                            'show'        => false,
                            'link'        => [
                                'type'  => 'product',
                                'value' => '',
                            ],
                        ],
                        [
                            'image'       => '',
                            'description' => self::languagesFill('اینجا توضیحات متنی است'),
                            'show'        => false,
                            'link'        => [
                                'type'  => 'product',
                                'value' => '',
                            ],
                        ],
                        [
                            'image'       => '',
                            'description' => self::languagesFill('اینجا توضیحات متنی است'),
                            'show'        => false,
                            'link'        => [
                                'type'  => 'product',
                                'value' => '',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title'   => trans('PageBuilder::modules.left_image_right_text'),
                'code'    => 'left-image-right-text',
                'icon'    => '<i class="bi bi-layout-sidebar-reverse"></i>',
                'content' => [
                    'style'          => ['background_color' => ''],
                    'image_position' => 'left',
                    'title'          => self::languagesFill('چیدمان تصویر و متن چپ و راست'),
                    'subtitle'       => 'شما می‌توانید زیرعنوان تنظیم کنید',
                    'description'    => 'اینجا محتوای توضیحات است',
                    'image'          => '',
                    'button_text'    => 'متن دکمه',
                    'button_link'    => '',
                ],
            ],
            [
                'title'   => trans('PageBuilder::modules.brands'),
                'code'    => 'brands',
                'icon'    => '<i class="bi bi-trophy"></i>',
                'content' => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'title'         => self::languagesFill('برندهای همکار'),
                    'brands'        => [],
                    'columns'       => 6,
                    'autoplay'      => false,
                    'autoplaySpeed' => 3000,
                    'showNames'     => false,
                    'width'         => 'wide',
                    'itemHeight'    => 80,
                    'borderRadius'  => 8,
                    'padding'       => 12,
                    'borderWidth'   => 1,
                    'borderColor'   => '#f0f0f0',
                    'borderStyle'   => 'solid',
                ],
            ],

            // ===== Extended Modules (Advanced Features) =====
            [
                'title'   => trans('PageBuilder::modules.brand_products'),
                'code'    => 'brand-products',
                'icon'    => '<i class="bi bi-tags"></i>',
                'content' => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'limit'      => 8,
                    'brand_id'   => '',
                    'brand_name' => '',
                    'sort'       => 'sales_desc',
                    'floor'      => self::languagesFill(''),
                    'products'   => [],
                    'title'      => self::languagesFill('محصولات برند'),
                    'subtitle'   => self::languagesFill(''),
                    'columns'    => 4,
                ],
            ],
            [
                'title'   => trans('PageBuilder::modules.card_slider'),
                'code'    => 'card-slider',
                'icon'    => '<i class="bi bi-card-list"></i>',
                'content' => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'floor'    => self::languagesFill(''),
                    'products' => [],
                    'title'    => self::languagesFill('عنوان ماژول'),
                    'subtitle' => self::languagesFill(''),
                    'screens'  => [
                        [
                            'products' => [],
                        ],
                    ],
                ],
            ],
            [
                'title'   => trans('PageBuilder::modules.multi_row_images'),
                'code'    => 'multi-row-images',
                'icon'    => '<i class="bi bi-grid-3x3"></i>',
                'content' => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'title'    => self::languagesFill('چیدمان تصاویر چند ردیفه'),
                    'subtitle' => self::languagesFill('زیرعنوان تصاویر چند ردیفه'),
                    'images'   => [],
                ],
            ],
            [
                'title'   => trans('PageBuilder::modules.image_text_list'),
                'code'    => 'image-text-list',
                'icon'    => '<i class="bi bi-grid-3x3-gap"></i>',
                'content' => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'title'          => self::languagesFill('فهرست تصویر و متن'),
                    'imageTextItems' => [],
                    'columns'        => 4,
                    'autoplay'       => false,
                    'autoplaySpeed'  => 3000,
                    'showNames'      => true,
                    'width'          => 'wide',
                    'itemHeight'     => 120,
                    'borderRadius'   => 8,
                    'padding'        => 16,
                    'borderWidth'    => 1,
                    'borderColor'    => '#f0f0f0',
                    'borderStyle'    => 'solid',
                ],
            ],

            // ===== Advanced Modules (Professional Features) =====
            [
                'title'   => trans('PageBuilder::modules.four_image_plus'),
                'code'    => 'four-image-plus',
                'icon'    => '<i class="bi bi-layout-text-window"></i>',
                'content' => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'title'    => self::languagesFill('چیدمان چهار تصویر نسخه پیشرفته'),
                    'subtitle' => self::languagesFill('زیرعنوان چیدمان چهار تصویر نسخه پیشرفته'),
                    'images'   => [
                        [
                            'image'       => '',
                            'description' => self::languagesFill('اینجا توضیحات متنی است'),
                            'show'        => true,
                            'link'        => [
                                'type'  => 'product',
                                'value' => '',
                            ],
                        ],
                        [
                            'image'       => '',
                            'description' => self::languagesFill('اینجا توضیحات متنی است'),
                            'show'        => false,
                            'link'        => [
                                'type'  => 'product',
                                'value' => '',
                            ],
                        ],
                        [
                            'image'       => '',
                            'description' => self::languagesFill('اینجا توضیحات متنی است'),
                            'show'        => false,
                            'link'        => [
                                'type'  => 'product',
                                'value' => '',
                            ],
                        ],
                        [
                            'image'       => '',
                            'description' => self::languagesFill('اینجا توضیحات متنی است'),
                            'show'        => false,
                            'link'        => [
                                'type'  => 'product',
                                'value' => '',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title'   => trans('PageBuilder::modules.article'),
                'code'    => 'article',
                'icon'    => '<i class="bi bi-file-text"></i>',
                'content' => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'title'    => self::languagesFill('ماژول مقاله'),
                    'subtitle' => self::languagesFill('زیرعنوان مقاله'),
                    'articles' => [],
                    'columns'  => 4,
                ],
            ],
            [
                'title'   => trans('PageBuilder::modules.video'),
                'code'    => 'video',
                'icon'    => '<i class="bi bi-camera-video"></i>',
                'content' => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'videoType'   => 'local',
                    'videoUrl'    => '',
                    'coverImage'  => self::languagesFill(''),
                    'title'       => self::languagesFill('عنوان ویدیو'),
                    'description' => self::languagesFill('توضیحات ویدیو'),
                    'autoplay'    => false,
                    'loop'        => false,
                    'muted'       => false,
                    'controls'    => true,
                    'width'       => 'wide',
                ],
            ],
        ];
    }

    /**
     * Multilingual field filling
     */
    private static function languagesFill(string $text): array
    {
        $languages = locales();
        $locale    = locale_code();

        if (empty($languages)) {
            return [$locale => $text];
        }

        $result = [];
        foreach ($languages as $lang) {
            $result[$lang['code']] = $text;
        }

        return $result;
    }
}
