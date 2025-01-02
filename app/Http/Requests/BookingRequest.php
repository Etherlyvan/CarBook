<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vehicle_id' => 'required|exists:vehicles,id',
            'requested_by' => 'required|string|max:255',
            'approver_level_1' => 'required|exists:users,id',
            'approver_level_2' => 'required|exists:users,id|different:approver_level_1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'approver_level_2.different' => 'Approver Level 2 must be different from Approver Level 1.',
        ];
    }
}
