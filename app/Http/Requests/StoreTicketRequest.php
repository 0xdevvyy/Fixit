<?php

namespace App\Http\Requests;

use App\Enum\TicketCategory;
use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //will pass it as true first
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'assigned_to' => ['nullable', 'exists:users,id'],
            'building_id' => ['required', 'exists:buildings,id'],

            'title' => ['required', 'string', 'min:3', 'max:50'],
            'description' => ['required', 'string', 'min:3', 'max:255'],

            'ticket_number' => [
                'required',
                'string',
                'unique:tickets,ticket_number',
            ],

            'room' => ['nullable', 'string', 'max:50', 'min:3'],

            'category' => ['nullable', new Enum(TicketCategory::cases())],
            'priority' => ['nullable', new Enum(TicketPriority::cases())],
            'status' => ['nullable', new Enum(TicketStatus::cases())],
        ];
    }
}
