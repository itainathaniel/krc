<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    
    public function show(Member $member)
    {
    	return view('members.show')
    		->withMember($member);
    }
}
