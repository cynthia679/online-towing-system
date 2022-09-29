<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        /**
         * Category apis
         */
        'api/v1/category/index',
        'api/v1/category/create',
        'api/v1/category/update',
        'api/v1/category/delete',
        'api/v1/category/findById',
        /**
         * Location apis
         */
        'api/v1/location/index',
        'api/v1/location/create',
        'api/v1/location/update',
        'api/v1/location/delete',
        'api/v1/location/findById'
    ];
}
