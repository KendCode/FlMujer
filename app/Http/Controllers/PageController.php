<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function contacto()
    {
        return view('pages.contacto');
    }
    public function testimonios() {
        return view('pages.testimonios');
    }

    public function actividades() {
        return view('pages.actividades');
    }
}
