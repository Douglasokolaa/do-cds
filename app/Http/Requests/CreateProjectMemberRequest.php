<?php

namespace App\Http\Requests;

use App\Enums\Batch;
use App\Enums\ProjectMemberType;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class CreateProjectMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
                'year' => ['required', 'date_format:Y'],
                'batch' => ['required', new EnumValue(Batch::class)],
                'name' => ['required', 'string'],
                'email' => ['required', 'email'],
                'position' => ['required', 'string'],
                'facebook_link' => ['required', 'active_url'],
                'state_code' => ['required', 'exists:states'],
                'phone_number' => ['required', 'max:16'],
                'instagram' => ['required', 'string'],
                'type' => ['required', new EnumValue(ProjectMemberType::class)],
        ];
    }
}
