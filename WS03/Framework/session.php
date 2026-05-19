<?php

namespace Framework;

class Session
{
    /**
     * Start a session
     * @return void
     * 
     */

    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            \session_start();
        }
    }

    /**
     * Set a session key value pair
     * 
     * @param string $key
     * @param mixed $value 
     * 
     * @return void
     * 
     */

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get a value by key
     * 
     * @param string $key
     * @param mixed $default
     * 
     * @return mixed $value
     * 
     */

    public static function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * check if a session key exists
     * 
     * @param string $key
     * 
     * @return bool
     * 
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove a session key
     * 
     * @param string $key
     * 
     * @return void
     * 
     */

    public static function clear($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * clear all session data
     * 
     * @return void
     * 
     */
    public static function clearAll()
    {
        session_unset();
        session_destroy();
    }
}
