<?php

namespace Codecasts\Units\Auth\Routes;

use Codecasts\Support\Routing\Http\RouteFile;

/**
 * Web Routes.
 */
class Web extends RouteFile
{
    /**
     * Declare Web Routes.
     */
    public function routes()
    {
        // Authentication Routes...
        $this->router->get('login', 'LoginController@showLoginForm')->name('login');
        $this->router->post('login', 'LoginController@login');
        $this->router->post('logout', 'LoginController@logout')->name('logout');

        // Registration Routes...
        $this->router->get('register', 'RegisterController@showRegistrationForm')->name('register');
        $this->router->post('register', 'RegisterController@register');

        // Password Reset Routes...
        $this->router->get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        $this->router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        $this->router->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        $this->router->post('password/reset', 'ResetPasswordController@reset')->name('password.update');


        // Email Verification Routes...
        $this->router->get('email/verify', 'VerificationController@show')->name('verification.notice');
        $this->router->get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
        $this->router->get('email/resend', 'VerificationController@resend')->name('verification.resend');
    }
}
