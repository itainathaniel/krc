<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewMember;
use App\Member;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    
    public function index()
    {
    	$members = Member::all();

    	return view('admin.members.index')
    		->withMembers($members);
    }

    public function create()
    {
    	return view('admin.members.create')
    		->withMember(new Member);
    }

    public function store(NewMember $form)
    {
    	$member = Member::swear($form);

    	return redirect()
    		->route('admin.members.show', [$member]);
    }

    public function show(Member $member)
    {
    	return view('admin.members.show')
    		->withMember($member);
    }

    public function edit(Member $member)
    {
    	return view('admin.members.edit')
    		->withMember($member);
    }

    public function update(NewMember $form, Member $member)
    {
    	$member = $member->update($form->toArrya());

    	return redirect()
    		->route('admin.members.show', [$member]);
    }
}
