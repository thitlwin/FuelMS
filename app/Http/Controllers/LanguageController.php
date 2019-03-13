<?php

namespace PowerMs\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Redirect;

class LanguageController extends Controller
{
	public function index()
    {
    	if (!\Session::has('locale')) {
    		\Session::put('locale',Input::get('locale'));
    	}else{
    		\Session::set('locale',Input::get('locale'));
    	}
      return Redirect::back(); 
    }
}
