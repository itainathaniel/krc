<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function index()
    {
        return redirect()->route('brb');

        $membersInside = Member::inside()->get();

        $membersLatestIn = Member::inside()->orderBy('updated_at', 'desc')->take(6)->get();
        $membersLatestOut = Member::outside()->orderBy('updated_at', 'desc')->take(6)->get();

        return view('pages.index', compact('membersInside', 'membersLatestIn', 'membersLatestOut'));
    }

    public function brb()
    {
        return view('brb');
    }
}
