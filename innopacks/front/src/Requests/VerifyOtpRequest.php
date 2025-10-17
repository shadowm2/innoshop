<?php
namespace InnoShop\Front\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string',
            'code'  => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'phone' => front_trans('login.phone'),
            'code'  => front_trans('login.code'),
        ];
    }
}
