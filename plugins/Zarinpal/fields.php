<?php
use InnoShop\Common\Repositories\CurrencyRepo;

$currencies = CurrencyRepo::getInstance()->asOptions();

return [
    [
        'name'      => 'merchant_id',
        'label_key' => 'common.merchant_id',
        'type'      => 'string',
        'required'  => true,
        'rules'     => 'required',
    ],
    [
        'name'      => 'currency',
        'label_key' => 'common.currency',
        'type'      => 'select',
        'required'  => true,
        'rules'     => 'required|size:3',
        'options'   => $currencies,
    ],
    [
        'name'      => 'sandbox_mode',
        'label_key' => 'common.sandbox_mode',
        'type'      => 'select',
        'options'   => [
            ['value' => '1', 'label_key' => 'common.enabled'],
            ['value' => '0', 'label_key' => 'common.disabled'],
        ],
        'required' => true,
    ],
];
