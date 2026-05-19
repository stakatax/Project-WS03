<?php

namespace App\controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;

class UserController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }


    /**
     * Show login Page
     * 
     * @return void
     * 
     */
    public function login()
    {
        \loadView('users/login');
    }

    /** 
     * Show create page
     * 
     *  @return void
     * 
     */
    public function create()
    {
        \loadView('users/create');
    }

    /**
     * Store user in database
     * 
     * @return void
     * 
     */

    public function store()
    {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $password = $_POST['password'];
        $password_confirmation = $_POST['password_confirmation'];

        $errors = [];

        if (!Validation::email($email)) {
            $errors[] = 'Email is not valid, Please enter a valid email address';
        }

        if (!Validation::string($name, 2, 50)) {
            $errors['name'] = 'Name must be between 2 and 50 characters';
        }

        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be atleast 6 characters';
        }

        if (!Validation::match($password, $password_confirmation)) {
            $errors['password_confirmation'] = 'Passwords do not match';
        }

        if (!empty($errors)) {
            \loadView('users/create', [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email,
                    'city' => $city,
                    'state' => $state
                ]
            ]);
            exit;
        }

        //check if email already exists
        $params = [
            'email' => $email,
        ];
        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

        if ($user) {
            $errors['email'] = 'Email already exists, Please use a different email address';
            \loadView('users/create', [
                'errors' => $errors,
            ]);
            exit;
        }

        //check user account
        $params = [
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'state' => $state,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $this->db->query('INSERT INTO users (name, email, city, state, password) 
        VALUES (:name, :email, :city, :state, :password)', $params);

        //get new user id
        $user_id = $this->db->conn->lastInsertId();

        Session::set('user', [
            'id' => $user_id,
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'state' => $state
        ]);



        \redirect('/');
    }

    /**
     * Logout user kill session
     * 
     * @return void
     * 
     */
    public function logout()
    {
        Session::clearAll('user');
        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);

        redirect('/');
    }


    /**
     * 
     * Authenticate a user with email and password
     * 
     * @return void
     */

    public function authenticate()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors = [];

        //Validation
        if (!Validation::email($email)) {
            $errors[] = 'Email is not valid, Please enter a valid email address';
        }

        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be atleast 6 characters';
        }


        //check for errors
        if (!empty($errors)) {
            loadView('users/login', [
                'errors' => $errors,
                'user' => [
                    'email' => $email,
                ]
            ]);
            exit;
        }

        //check fo email
        $params = [
            'email' => $email,
        ];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

        if (!$user) {
            $errors['email'] = 'Incorrect email or password';
            loadView(
                'users/login',
                [
                    'errors' => $errors
                ]
            );
            exit;
        }

        //verify password
        if (!password_verify($password, $user->password)) {
            $errors['email'] = 'Incorrect email or password';
            loadView(
                'users/login',
                [
                    'errors' => $errors
                ]
            );
            exit;
        }

        //set user session
        Session::set('user', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'city' => $user->city,
            'state' => $user->state
        ]);

        redirect('/');
    }
}
