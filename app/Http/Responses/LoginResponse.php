<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $role = $request->user()->role;

        $redirectUrl = match ($role) {
            'admin' => route('admin.dashboard'),
            default => route('customer.catalog'),
        };

        return $request->wantsJson()
            ? new JsonResponse(['two_factor' => false])
            : new RedirectResponse($redirectUrl);
    }
}
