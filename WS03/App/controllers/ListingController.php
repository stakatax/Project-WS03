<?php

namespace App\controllers;

use Framework\Database;
use Framework\Validation;

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

    /**
     * store data in database
     *
     * 
     * @return void
     */

    public function store()
    {
        $allowfields = [
            'title',
            'description',
            'salary',
            'tags',
            'company',
            'address',
            'city',
            'state',
            'email',
            'requirements',
            'benefits'
        ];

        $newListingData = array_intersect_key($_POST, array_flip($allowfields));

        $newListingData['user_id'] = 1; // hardcoded user id for now

        $newListingData = array_map('sanitize', $newListingData);

        $requiredFields = ['title', 'description', 'email', 'city', 'state'];

        $errors = [];

        foreach ($requiredFields as $fields) {
            if (empty($newListingData[$fields]) || !Validation::string($newListingData[$fields])) {
                $errors[$fields] = ucfirst($fields) . ' is required';
            }
        }

        if (!empty($errors)) {
            //reload view with error
            loadView('listings/create', [
                'errors' => $errors,
                'listing' => $newListingData
            ]);
        } else {
            //Submit data
            echo "Success";
        }
    }
}
