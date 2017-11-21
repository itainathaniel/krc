<?php

namespace App;

use App\Member;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;

class Minute extends Model
{

	protected $fillable = ['member_id', 'day', 'dotw', 'minutes'];

    public $timestamps = false;

    public function member()
    {
    	return $this->belongsTo(Member::class);
    }

    /**
     * Compute a range between two dates, and generate
     * a plain array of Carbon objects of each day in it.
     *
     * @param  \Carbon\Carbon  $from
     * @param  \Carbon\Carbon  $to
     * @param  bool  $inclusive
     * @return array|null
     *
     * @author Tristan Jahier <http://stackoverflow.com/a/38534610/1824374>
     */
    public static function dateRange(Carbon $from, Carbon $to)
    {
        if ($from->gt($to)) {
            return null;
        }

        // Clone the date objects to avoid issues, then reset their time
        $from = $from->copy()->startOfDay();
        $to = $to->copy()->startOfDay();

        // Include the end date in the range
        $to->addDay();

        $step = CarbonInterval::day();
        $period = new \DatePeriod($from, $step, $to);

        // Convert the DatePeriod into a plain array of Carbon objects
        $range = [];

        foreach ($period as $day) {
            $range[] = new Carbon($day);
        }

        return ! empty($range) ? collect($range) : null;
    }

    public static function keep(Member $member, VisitLog $leaving)
    {
        if ($leaving->processed) {
            return false;
        }

        $entrance = $leaving->getEntrance();

        if (!$entrance || $entrance->processed) {
            return false;
        }

        $range = self::dateRange($entrance->created_at, $leaving->created_at);

        if (is_null($range)) {
            return false;
        }

        $start_date = $entrance->created_at->copy();
        $end_date   = $leaving->created_at->copy();

        $range->each(function($day) use ($member, $start_date, $end_date) {
            self::persist([
                'member_id' => $member->id,
                'day' => $start_date->format('Y-m-d'),
                'dotw' => $start_date->format('w'),
                'minutes' => $start_date->diffInMinutes(
                    $day->format('Y-m-d') != $end_date->format('Y-m-d')
                        ? $start_date->copy()->endOfDay()
                        : $end_date
                    )
            ]);

            $start_date = $start_date->addDay()->startOfDay();
        });

        $entrance->process();
        $leaving->process();

        return $range->count();
    }

    public static function persist($day)
    {
        if ($day['minutes'] == 0) {
            return true;
        }

        $self = self::firstOrCreate([
            'member_id' => $day['member_id'],
            'day' => $day['day'],
        ], [
            'dotw' => $day['dotw'],
            'minutes' => 0
        ]);

        $self->minutes += $day['minutes'];
        $self->save();
    }
}
