<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * المسارات المستثناة من التحقق CSRF.
     *
     * @var array
     */
    protected $except = [
        'api/*',  // استثناء جميع المسارات التي تبدأ بـ api/
    ];
}
