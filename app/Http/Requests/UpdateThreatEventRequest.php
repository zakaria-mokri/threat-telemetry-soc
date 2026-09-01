<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateThreatEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'source_ip' => ['sometimes', 'required', 'ip'],
            'destination_ip' => ['sometimes', 'required', 'ip'],
            'threat_type' => ['sometimes', 'required', 'string', 'max:255'],
            'severity' => ['sometimes', 'required', 'in:low,medium,high,critical'],
            'location' => ['sometimes', 'nullable', 'string', 'max:100'],
            'payload_details' => ['sometimes', 'nullable', 'string'],
        ];
    }
}