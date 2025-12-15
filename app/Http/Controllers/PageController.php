<?php

namespace App\Http\Controllers;

class PageController extends Controller{
    
    public function about() {
        return view('pages.about');
    }

    public function mainFeatures() {
        return view('pages.main_features');
    }

    public function contacts() {
        return view('pages.contacts');
    }
}?>