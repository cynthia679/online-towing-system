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
        'api/v1/location/findById',
        /**
         * Client apis
         */
        'api/v1/client/index',
        'api/v1/client/create',
        'api/v1/client/update',
        'api/v1/client/delete',
        'api/v1/client/findById',
       /**
        * CustomerRequest apis
        */
        'api/v1/customerRequest/index',
        'api/v1/customerRequest/create',
        'api/v1/customerRequest/update',
        'api/v1/customerRequest/delete',
        'api/v1/customerRequest/findById',
        /**
        * Order apis
          */
        'api/v1/order/index',
        'api/v1/order/create',
        'api/v1/order/update',
        'api/v1/order/delete',
        'api/v1/order/findById',
        /**
       * Product apis
        */
        'api/v1/product/index',
        'api/v1/product/create',
        'api/v1/product/update',
        'api/v1/product/delete',
        'api/v1/product/findById',
        /**
         * User apis
         */
        'api/v1/user/index',
        'api/v1/user/create',
        'api/v1/user/update',
        'api/v1/user/delete',
        'api/v1/user/findById',
        /**
        * Transaction apis
         */
        'api/v1/transaction/index',
        'api/v1/transaction/create',
        'api/v1/transaction/update',
        'api/v1/transaction/delete',
        'api/v1/transaction/findById',
         /**
        * Setting apis
          */
        'api/v1/setting/index',
        'api/v1/setting/create',
        'api/v1/setting/update',
        'api/v1/setting/delete',
        'api/v1/setting/findById'
    ];
}
