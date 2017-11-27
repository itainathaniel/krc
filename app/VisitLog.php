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

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    
    public static function newEntry(Member $member)
    {
    	return self::create([
    		'member_id' => $member->id,
    		'present' => $member->present
    	]);
    }

    public function getEntrance()
    {
        return VisitLog::where('id', '<', $this->id)
            ->where('member_id', $this->member_id)
            ->where('present', true)
            ->latest()
            ->take(1)
            ->first();
    }

    public function getLeaving()
    {
        return VisitLog::where('id', '>', $this->id)
            ->where('member_id', $this->member_id)
            ->where('present', false)
            ->oldest()
            ->take(1)
            ->first();
    }

    public function process()
    {
        $this->update(['processed' => true]);
    }
}
