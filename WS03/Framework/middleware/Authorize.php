<?php

namespace Framework\middleware;

use Framework\Session;

class Authorize
{

    /**
     * check if user is authenticated
     * 
     *  @return bool
     */
    public function isAuthenticated()
    {
        return Session::has('user');
    }


    /**
     *  Handle an incoming request.
     * 
     * @param string $role
     * @return bool
     */
    public function handle($role)
    {
        if ($role === 'guest' && $this->isAuthenticated()) {
            return redirect('/');
            exit;
        } elseif ($role === 'auth' && !$this->isAuthenticated()) {
            return redirect('/auth/login');
            exit;
        }
    }
}
