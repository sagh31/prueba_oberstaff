<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $request->user()->load('company');

        return view('home', [
            'user' => $user,
            'company' => $user->company,
        ]);
    }
}
