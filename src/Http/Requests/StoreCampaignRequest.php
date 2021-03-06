<?php

namespace BajakLautMalaka\PmiDonatur\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCampaignRequest extends FormRequest
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
            'type_id' => 'required|exists:campaign_types,id',
            'title' => 'required|unique:campaigns',
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'amount_goal' => Rule::requiredIf($this->input('fundraising') == 1),
            'start_campaign' => 'nullable|date',
            'finish_campaign' => 'nullable|date',
            'fundraising' => 'required|boolean',
            'publish'=>'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}
