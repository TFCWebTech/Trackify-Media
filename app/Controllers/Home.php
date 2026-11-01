<?php

namespace App\Controllers;

class Home extends BaseController
{
    // public function __construct()
    // {
    //     // Load the URL helper
    //     helper('url');
    // }
    
    public function index(): string
    {
        echo view('common/header');

        echo view('home');

        echo view('common/footer');

        return '';
    }
}
