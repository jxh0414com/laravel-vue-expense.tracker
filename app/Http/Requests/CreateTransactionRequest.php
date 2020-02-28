<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'on' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'type' => ['required'],
            'date' => ['required', 'string'],
            'location' => ['required', 'string']
        ];
    }
}
