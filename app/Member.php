<?php

namespace App;

use App\VisitLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use SimpleXMLElement;

class Member extends Model
{

	protected $fillable = [
		'knesset_id',
		'party_id',
		'active',
		'image',
		'first_name',
		'last_name',
		'first_name_english',
		'last_name_english',
		'gender',
		'mk_status_id',
		'birth_date',
		'present'
	];
	
	protected $dates = ['bitch_date'];

	public static function boot()
	{
		self::created(function ($knessetmember) {
			Event::fire(new newKnessetMember($knessetmember));
		});
	}

	public function getNameAttribute()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	public function getNameEnglishAttribute()
	{
		return $this->first_name_english . ' ' . $this->last_name_english;
	}

	public function getSlugAttribute()
	{
		return str_slug($this->name_english);
	}

	public function scopeActive($query)
	{
		return $query->where('active', 1);
	}

	public function scopeInside($query)
	{
		return $query->where('present', 1);
	}

	public function scopeOutside($query)
	{
		return $query->where('present', 0);
	}

	public static function fetchFromTheKnesset($knesset_id)
	{
		$url = "http://knesset.gov.il/KnessetOdataService/KnessetMembersData.svc/View_mk_individual({$knesset_id})";

		try {
			$xml = file_get_contents($url);
		} catch (Exception $e) {
			return $e;
		}

		$sxe = new SimpleXMLElement($xml);

		$element = $sxe->content->children('m', true);
		$properties = $element->properties;
		$elements = $properties->children('d', true);

		$member = new static();

		$member->knesset_id = (string) $elements->mk_individual_id;
        $member->party_id = 1;
        $member->active = $member->getMkStatusId($elements->mk_status_id);
        $member->image = (string) $elements->mk_individual_photo;
        $member->first_name = (string) $elements->mk_individual_first_name;
        $member->last_name = (string) $elements->mk_individual_name;
        $member->first_name_english = (string) $elements->mk_individual_first_name_eng;
        $member->last_name_english = (string) $elements->mk_individual_name_eng;
        $member->gender = $member->getMkIndividualGender($elements->mk_individual_gender);
        $member->birth_date = $member->getMkIndividualBirthDate($elements->mk_individual_birth_date);
        $member->present = $member->getMkIndividualPresent($elements->mk_individual_present);

		return $member;
	}

	public static function swear(Array $params)
	{
		return self::create($params);
	}

	public function usedTheDoor()
	{
		$this->update(['present' => !$this->present]);

		VisitLog::newEntry($this);
		// raise event
	}

	private function getMkStatusId($status)
	{
		$attributes = $status->attributes('m', true);

		if ($attributes['null']) {
			return false;
		}

		return true;
	}

	private function getMkIndividualGender($gender)
	{
		$attributes = $gender->attributes('m', true);

		if ($attributes['null']) {
			return 'female';
		}

		return 'male';
	}

	private function getMkIndividualPresent($present)
	{
		$attributes = $present->attributes('m', true);

		if (
			$attributes['null'] ||
			(
				$attributes['type'] == 'Edm.Boolean' &&
				$present == 'false'
			)
		) {
			return false;
		}

		return true;
	}

	private function getMkIndividualBirthDate($birth_date)
	{
		$attributes = $birth_date->attributes('m', true);

		if ($attributes['null']) {
			return Carbon::now();
		}

		return $birth_date;
	}
}
