<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;


class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'user_bio' => ['nullable', 'string'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'profile_photo' => [
                'nullable',
                File::types(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                    ->max('4mb')
            ],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated();

        if ($this->hasFile('profile_photo')) {
            $filePhoto = $this->file('profile_photo');
            $fileName = time() . '_' . $filePhoto->getClientOriginalName();
            $filePath = 'assets/profile-images/' . $fileName;

            $filePhoto->move(public_path('assets/profile-images/'), $fileName);

            $validated['profile_photo'] = $filePath;
        }

        return $validated;
    }
}
