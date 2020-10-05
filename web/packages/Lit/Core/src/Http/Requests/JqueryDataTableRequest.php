<?php


namespace Lit\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JqueryDataTableRequest extends FormRequest
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
            'draw' => 'integer',
            'columns' => 'array',
            'order' => 'array',
            'start' => 'integer',
            'length' => 'integer',
            'search' => 'array',
        ];
    }
}