<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            'jenis_kelamin' => ['nullable', Rule::in(['Laki-laki', 'Perempuan'])],
            'alamat' => ['nullable', 'string'],
            'kota' => ['nullable', 'string'],
            'kecamatan' => ['nullable', 'string'],
            'kelurahan' => ['nullable', 'string'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'jenis_kelamin' => $input['jenis_kelamin'] ?? null,
                'alamat' => $input['alamat'] ?? null,
                'kota' => $input['kota'] ?? null,
                'kecamatan' => $input['kecamatan'] ?? null,
                'kelurahan' => $input['kelurahan'] ?? null,
                'no_telepon' => $input['no_telepon'] ?? null,
            ])->save();
        }
    }

    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'jenis_kelamin' => $input['jenis_kelamin'] ?? null,
            'alamat' => $input['alamat'] ?? null,
            'kota' => $input['kota'] ?? null,
            'kecamatan' => $input['kecamatan'] ?? null,
            'kelurahan' => $input['kelurahan'] ?? null,
            'no_telepon' => $input['no_telepon'] ?? null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
