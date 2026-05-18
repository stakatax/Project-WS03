<?php

namespace App\controllers;

use Framework\Database;

class ListingController
{

    protected $db;
    public function __construct()
    {
        $config = require basePath('config/db.php');

        $this->db = new Database($config);
    }

    public function index()
    {

        $listings = $this->db->query('SELECT * FROM listings')->fetchAll();


        loadView(
            'listings/index',
            ['listings' =>
            $listings]
        );
    }

    public function create()
    {

        loadView('listings/create');
    }

    public function show($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        //check if listing exists
        if (!$listing) {
            ErrorController::notFound('Listing Not Found');
            return;
        }

        loadView('listings/show', [
            'listing' => $listing
        ]);
    }
}
