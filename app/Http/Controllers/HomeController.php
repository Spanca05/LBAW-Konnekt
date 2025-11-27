<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{       
        // Pagina inicial com jobposts
        public function index(){
            $jobposts = JobPost::orderBy('created_at', 'desc')->get();
            return view('pages.cards', ['jobposts' => $jobposts]);

    }
}
