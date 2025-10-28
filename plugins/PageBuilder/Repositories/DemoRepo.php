<?php
/**
 * Copyright (c) Since 2024 InnoShop - All Rights Reserved
 *
 * @link       https://www.innoshop.com
 * @author     InnoShop <team@innoshop.com>
 * @license    https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace Plugin\PageBuilder\Repositories;

class DemoRepo
{
    /**
     * 获取首页演示数据
     */
    public static function getHomeDemoData(): array
    {
        return [
            [
                'title'     => trans('PageBuilder::modules.slideshow'),
                'code'      => 'slideshow',
                'module_id' => 'module-slideshow-demo-001',
                'icon'      => '<i class="bi bi-images"></i>',
                'content'   => [
                    'images' => [
                        [
                            'image' => asset('images/demo/banner/banner-1-cn.jpg'),
                            'show'  => false,
                            'link'  => [
                                'type'  => 'product',
                                'value' => 1,
                                'link'  => '',
                            ],
                        ],
                        [
                            'image' => asset('images/demo/banner/banner-2-cn.jpg'),
                            'show'  => true,
                            'link'  => [
                                'type'  => 'category',
                                'value' => 1,
                                'link'  => '',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title'     => trans('PageBuilder::modules.single_image'),
                'code'      => 'single-image',
                'module_id' => 'module-single-image-demo-002',
                'icon'      => '<i class="bi bi-image"></i>',
                'content'   => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'images' => [
                        [
                            'image' => asset('images/demo/banner/banner-2-en.jpg'),
                            'show'  => true,
                            'link'  => [
                                'type'  => 'category',
                                'value' => 5,
                                'link'  => '',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title'     => trans('PageBuilder::modules.custom_products'),
                'code'      => 'custom-products',
                'module_id' => 'module-custom-products-demo-003',
                'icon'      => '<i class="bi bi-box"></i>',
                'content'   => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'floor' => [
                        'zh-cn' => '',
                        'en'    => '',
                    ],
                    'products' => [
                        [
                            'id'           => 1,
                            'name'         => 'کت و شلوار شیک شهری با برش کلاسیک',
                            'image_big'    => asset('images/demo/product/1-600x600.png'),
                            'image_format' => '',
                            'price_format' => '$123.50',
                            'active'       => true,
                        ],
                        [
                            'id'           => 2,
                            'name'         => 'لباس مجلسی درخشان کهکشانی',
                            'image_big'    => asset('images/demo/product/2-600x600.png'),
                            'image_format' => '',
                            'price_format' => '$123.50',
                            'active'       => true,
                        ],
                        [
                            'id'           => 3,
                            'name'         => 'بارانی سبک بهاری طلوع صبح',
                            'image_big'    => asset('images/demo/product/3-600x600.png'),
                            'image_format' => '',
                            'price_format' => '$123.50',
                            'active'       => true,
                        ],
                        [
                            'id'           => 4,
                            'name'         => 'پیراهن کلاسیک مینیمال ساده اما شیک',
                            'image_big'    => asset('images/demo/product/4-600x600.png'),
                            'image_format' => '',
                            'price_format' => '$123.50',
                            'active'       => true,
                        ],
                    ],
                    'title' => [
                        'zh-cn' => 'محصولات پیشنهادی',
                        'en'    => 'Hot Items',
                    ],
                ],
            ],
            [
                'title'     => trans('PageBuilder::modules.category_products'),
                'code'      => 'category-products',
                'module_id' => 'module-category-products-demo-004',
                'icon'      => '<i class="bi bi-collection"></i>',
                'content'   => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'limit'         => '4',
                    'order'         => 'asc',
                    'category_id'   => 1,
                    'category_name' => 'مد و پوشاک',
                    'sort'          => 'sales',
                    'floor'         => [
                        'zh-cn' => '',
                        'en'    => '',
                    ],
                    'products' => [
                        [
                            'id'           => 1,
                            'name'         => 'شلوار جین کمر بالا مدرن کلاسیک',
                            'image_big'    => asset('images/demo/product/5-600x600.png'),
                            'image_format' => '',
                            'price_format' => '$123.50',
                            'active'       => true,
                        ],
                        [
                            'id'           => 2,
                            'name'         => 'شال و روسری رنگارنگ با منگوله‌های فانتزی',
                            'image_big'    => asset('images/demo/product/6-600x600.png'),
                            'image_format' => '',
                            'price_format' => '$123.50',
                            'active'       => true,
                        ],
                        [
                            'id'           => 3,
                            'name'         => 'ست سویشرت سفید مردانه',
                            'image_big'    => asset('images/demo/product/7-600x600.png'),
                            'image_format' => '',
                            'price_format' => '$123.50',
                            'active'       => true,
                        ],
                        [
                            'id'           => 4,
                            'name'         => 'بلوز توری زنانه شیک و جذاب',
                            'image_big'    => asset('images/demo/product/8-600x600.png'),
                            'image_format' => '',
                            'price_format' => '$123.50',
                            'active'       => true,
                        ],
                    ],
                    'title' => [
                        'zh-cn' => 'محصولات دسته‌بندی',
                        'en'    => 'New Summer',
                    ],
                ],
            ],
            [
                'title'     => trans('PageBuilder::modules.latest_products'),
                'code'      => 'latest-products',
                'module_id' => 'module-latest-products-demo-005',
                'icon'      => '<i class="bi bi-star"></i>',
                'content'   => [
                    'style' => [
                        'background_color' => '',
                    ],
                    'limit' => '4',
                    'floor' => [
                        'zh-cn' => '',
                        'en'    => '',
                    ],
                    'products' => [
                        [
                            'id'           => 1,
                            'name'         => 'کت و شلوار شیک شهری با برش کلاسیک',
                            'image_big'    => asset('images/demo/product/1-600x600.png'),
                            'image_format' => '',
                            'price_format' => '$123.50',
                            'active'       => true,
                        ],
                        [
                            'id'           => 2,
                            'name'         => 'لباس مجلسی درخشان کهکشانی',
                            'image_big'    => asset('images/demo/product/2-600x600.png'),
                            'image_format' => '',
                            'price_format' => '$123.50',
                            'active'       => true,
                        ],
                        [
                            'id'           => 3,
                            'name'         => 'بارانی سبک بهاری طلوع صبح',
                            'image_big'    => asset('images/demo/product/3-600x600.png'),
                            'image_format' => '',
                            'price_format' => '$123.50',
                            'active'       => true,
                        ],
                        [
                            'id'           => 4,
                            'name'         => 'پیراهن کلاسیک مینیمال ساده اما شیک',
                            'image_big'    => asset('images/demo/product/4-600x600.png'),
                            'image_format' => '',
                            'price_format' => '$123.50',
                            'active'       => true,
                        ],
                    ],
                    'title' => [
                        'zh-cn' => 'جدیدترین محصولات',
                        'en'    => 'New Products',
                    ],
                ],
            ],
        ];
    }
}
