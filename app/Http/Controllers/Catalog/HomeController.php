<?php

namespace App\Http\Controllers\Catalog;

use Illuminate\Http\Request;
use Cookie;
use Mail;
use DB;
use DOMDocument;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->route('personal');
    }
}
