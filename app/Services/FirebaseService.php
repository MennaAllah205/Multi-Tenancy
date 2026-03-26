<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected $auth;

    protected $database;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(config('firebase.credentials'))
            ->withDatabaseUri(config('firebase.database_url'));

        $this->auth = $factory->createAuth();
        $this->database = $factory->createDatabase();
    }

    public function auth()
    {
        return $this->auth;
    }

    public function database()
    {
        return $this->database;
    }
}
