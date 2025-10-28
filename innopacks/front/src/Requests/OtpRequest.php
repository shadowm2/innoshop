<?php
namespace InnoShop\Front\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'phone' => front_trans('login.phone'),
        ];
    }
}
