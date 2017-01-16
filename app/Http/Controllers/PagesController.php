<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function index()
    {
        // return redirect()->route('brb');

        $members = Member::mk()->get();

        $membersLatestIn = Member::mk()->inside()->orderBy('updated_at', 'desc')->take(6)->get();
        $membersLatestOut = Member::mk()->outside()->orderBy('updated_at', 'desc')->take(6)->get();

        return view('pages.index', compact('members', 'membersLatestIn', 'membersLatestOut'));
    }

    public function brb()
    {
        return view('brb');
    }
}
