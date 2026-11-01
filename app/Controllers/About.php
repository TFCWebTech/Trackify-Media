<?php

namespace App\Controllers;

class About extends BaseController
{
    public function __construct()
    {
        // Load the URL helper
        helper('url');
    }
    
    public function index(): string
    {
        echo view('common/header');

        echo view('about');

        echo view('common/footer');

        return '';
    }
}
