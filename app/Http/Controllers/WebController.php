<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function company()
    {
        return view('web.page');
    }

    public function getContact()
    {
        return view('web.contact_form');
    }
    
}
