<?php

namespace App\Http\Requests\Manager;

use App\Manager\Unit;
use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
        $slug = $this->route()->getParameter('slug');


        switch ($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'code'    => 'required|unique:units',
                    'name'    => 'required',
                ];
            }
            case 'PUT':
                $unit = Unit::findBySlug($slug);
                return [
                    'code'    => "required|unique:units,code,{$unit->id},id",
                    'name'    => 'required',
                ];
            case 'PATCH':
            {
                $unit = Unit::findBySlug($slug);
                return [
                    'code'    => "required|unique:units,code,{$unit->id},id",
                    'name'    => 'required',
                ];
            }
            default:
                break;
        }
    }

    public function messages ()
    {
        return [
            'code.required'    => 'Bạn cần phải nhập mã cho đơn vị',
            'code.unique'      => 'Mã đơn vị bạn chọn đã được sử dụng',
        ];
    }
}
