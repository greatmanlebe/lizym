<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
public function share(Request $request): array
{
    return array_merge(parent::share($request), [
        'auth' => [
            'buyer' => auth('web')->check() ? auth('web')->user() : null,
            'seller' => auth('seller')->check() ? auth('seller')->user() : null,
        ],

        'csrf_token' => csrf_token(),
        'message' => session('message'),

    ]);
}


}


