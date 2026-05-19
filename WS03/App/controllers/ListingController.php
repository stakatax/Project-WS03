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

        $requiredFields = ['title', 'description', 'salary', 'email', 'city', 'state'];

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


            $fields = [];

            foreach ($newListingData as $field => $value) {
                $fields[] = "$field";
            }
            $fields = implode(', ', $fields);

            $value = [];

            foreach ($newListingData as $field => $value) {
                // covert empty string to null
                if ($value === '') {
                    $newListingData[$field] = null;
                }
                $values[] = ':' . $field;
            }

            $values = implode(', ', $values);

            $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";
            $this->db->query($query, $newListingData);

            redirect('/listings');
        }
    }
    /**
     * delete a listing
     *
     * @param array $params
     * @return void
     */
    public function destroy($params)
    {
        $id = $params['id'];
        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        //check if listing exists
        if (!$listing) {
            ErrorController::notFound('Listing Not Found');
            return;
        }
        $this->db->query('DELETE FROM listings WHERE id = :id', $params);


        //set flash message
        $_SESSION['success_message'] = 'Listing deleted successfully';


        redirect('/listings');
    }

    public function edit($params)
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

        loadView('listings/edit', [
            'listing' => $listing
        ]);
    }

    /** 
     * update listing data in database
     * @param array $params
     * @return void
     */

    public function update($params)
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

        $updateValues = array_intersect_key($_POST, array_flip($allowfields));

        $updateValues = array_map('sanitize', $updateValues);

        $requiredFields = ['title', 'description', 'salary', 'email', 'city', 'state'];

        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($updateValues[$field]) || !Validation::string($updateValues[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!empty($errors)) {
            loadView('listings/edit', [
                'listing' => $listing,
                'errors' => $errors
            ]);
            exit;
        } else {
            //submit to db
            $updateFields = [];

            foreach (array_keys($updateValues) as $field) {
                $updateFields[] = "{$field} = :{$field}";
            }

            $updateFields = implode(', ', $updateFields);

            $updateQuery = "UPDATE listings SET {$updateFields} WHERE id = :id";

            $updateValues['id'] = $id;
            $this->db->query($updateQuery, $updateValues);

            $_SESSION['success_message'] = 'Listing updated successfully';

            redirect('/listings/' . $id);
        }
    }
}
