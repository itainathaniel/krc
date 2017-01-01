<?php

namespace App;

use App\Member;
use Illuminate\Database\Eloquent\Model;

class VisitLog extends Model
{

	protected $fillable = [
		'member_id',
		'present',
		'processed',
	];
    
    public static function newEntry(Member $member)
    {
    	return self::create([
    		'member_id' => $member->id,
    		'present' => $member->present
    	]);
    }
}
