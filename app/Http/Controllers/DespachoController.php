<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DespachoController extends Controller
{
    public function index () {
        return view ('despachos.index');
    }
}
