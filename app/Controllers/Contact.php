<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function __construct()
    {
        // Load the URL helper
        helper('url');
    }
    
    public function index(): string
    {
        echo view('common/header');

        echo view('contact');

        echo view('common/footer');

        return '';
    }
}
