<?php

namespace ServiceTime\Calendar\Requests\Timetable;

use ServiceTime\Calendar\Requests\FormRequest;

/**
 * Даты переданные при запросе записей
 */
class DateParamsRequest extends FormRequest
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
            "date_start" => 'required|date_format:"d.m.Y"',
            "date_end" => 'required|date_format:"d.m.Y"',
        ];
    }

    public function getFormData()
    {
        $data = parent::getFromData();

        return $data;
    }
}
