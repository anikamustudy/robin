<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class MembershipReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check(); // Requires authentication
    }

    public function rules(): array
    {
        return [
            'reason' => 'required|string|max:255',
            'status' => 'in:rejected,blacklisted',
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required' => 'A reason is required to reject or blacklist the request.',
            'reason.string' => 'The reason must be a string.',
            'reason.max' => 'The reason may not exceed 255 characters.',
            'status.in' => 'The status must be either "rejected" or "blacklisted".',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
