<?php

namespace App\controllers;



class ErrorController
{

    /**
     * Error 404 not found
     * @return void
     */


    public static function notFound($message = 'Page Not Found')
    {
        http_response_code(404);
        loadView('errors/404', ['message' => $message]);


        loadView(
            'error',
            [
                'status' => '404',
                'message' => $message
            ]
        );
    }

    /**
     * Error 403 not anuthorized error
     * @return void
     */


    public static function unauthorized($message = 'You are not authorized to view this page')
    {
        http_response_code(403);
        loadView('errors/403', ['message' => $message]);


        loadView(
            'error',
            [
                'status' => '403',
                'message' => $message
            ]
        );
    }
}
