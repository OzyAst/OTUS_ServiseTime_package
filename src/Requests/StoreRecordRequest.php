<?php

namespace ServiceTime\Calendar\Requests;

/**
 * Данные для добавления записи
 */
class StoreRecordRequest extends FormRequest
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
            "date_start" => 'required|date_format:"Y-m-d H:i"',
        ];
    }
}
