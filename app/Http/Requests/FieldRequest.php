<?php

namespace App\Http\Requests;

use App\Manager\Field;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Validator;
class FieldRequest extends FormRequest
{

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize ()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules ()
	{
		$slug = $this->route()->getParameter('slug');
		$field = Field::findBySlug($slug);

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
					'code'    => 'required|unique:fields',
					'name'    => 'required',
					'unit_id' => 'required',
				];
			}
			case 'PUT':
				return [
					'code'    => "required|unique:fields,code,{$field->id},id",
					'name'    => 'required',
					'unit_id' => 'required',
				];
			case 'PATCH':
			{
				return [
					'code'    => "required|unique:fields,code,{$field->id},id",
					'name'    => 'required',
					'unit_id' => 'required',
				];
			}
			default:
				break;
		}

	}

	public function messages ()
	{
		return [
			'code.required'    => 'Bạn cần phải nhập mã cho lĩnh vực',
			'code.unique'      => 'Mã lĩnh vực bạn chọn đã được sử dụng',
			'unit_id.required' => 'Bạn phải chọn đơn vị tạo mã lĩnh vực'
		];
	}
}
