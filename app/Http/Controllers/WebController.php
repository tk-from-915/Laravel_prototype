<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function company()
    {
        return view('web.page');
    }

    public function getMenu_archive()
    {
        return view('web.menu_archive');
    }

    public function getContact()
    {
        return view('web.contact_form');
    }
    
}
