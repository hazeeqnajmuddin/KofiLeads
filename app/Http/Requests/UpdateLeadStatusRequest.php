<?php

namespace App\Http\Requests;

use App\Models\Lead;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'pipeline_status' => ['required', Rule::in(Lead::PIPELINE_STATUSES)],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
