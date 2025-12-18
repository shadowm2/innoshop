<?php
/**
 * Copyright (c) Since 2024 InnoShop - All Rights Reserved
 *
 * @link       https://www.sibzard.com
 * @author     InnoShop <team@innoshop.com>
 * @license    https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace InnoShop\Panel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
{
    /**
     * تعیین اینکه آیا کاربر مجاز به انجام این درخواست است یا خیر
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * دریافت قوانین اعتبارسنجی
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'type'                => 'required|in:select,radio,checkbox,text,textarea',
            'position'            => 'integer|min:0',
            'active'              => 'boolean',
            'translations'        => 'required|array',
            'translations.*.name' => 'required|string|max:255',
        ];
    }

    /**
     * دریافت پیام‌های خطای اعتبارسنجی
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'type.required'                => 'نوع گزینه نمی‌تواند خالی باشد',
            'type.in'                      => 'نوع گزینه باید یکی از موارد زیر باشد: select, radio, checkbox',
            'position.integer'             => 'ترتیب باید عدد صحیح باشد',
            'position.min'                 => 'ترتیب نمی‌تواند کمتر از 0 باشد',
            'active.boolean'               => 'وضعیت باید مقدار بولی باشد',
            'translations.required'        => 'اطلاعات ترجمه نمی‌تواند خالی باشد',
            'translations.array'           => 'اطلاعات ترجمه باید آرایه باشد',
            'translations.*.name.required' => 'نام گروه گزینه نمی‌تواند خالی باشد',
            'translations.*.name.string'   => 'نام گروه گزینه باید رشته باشد',
            'translations.*.name.max'      => 'نام گروه گزینه نمی‌تواند بیش از 255 کاراکتر باشد',
        ];
    }
}
