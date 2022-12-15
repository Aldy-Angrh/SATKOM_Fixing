<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // dump table role to seeder
        return view('welcome_message');
    }
}
