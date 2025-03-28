<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MembershipStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return  true; ;
    }


    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:membership_requests,email',
            'name' => 'required|string|max:255',
            'role' => 'required|in:bank,valuer,bank_staff,valuer_staff',
            'bank_id' => 'required_if:role,bank_staff|exists:bank,id',
            'branch_id' => 'nullable|exists:branch,id',
            'valuer_id' => 'required_if:role,valuer_staff|exists:valuer,id',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already in use.',
            'name.required' => 'The name field is required.',
            'role.required' => 'The role field is required.',
            'role.in' => 'Invalid role selected.',
            'bank_id.required_if' => 'The bank ID is required for bank staff.',
            'bank_id.exists' => 'The selected bank does not exist.',
            'branch_id.exists' => 'The selected branch does not exist.',
            'valuer_id.required_if' => 'The valuer ID is required for valuer staff.',
            'valuer_id.exists' => 'The selected valuer does not exist.',
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
