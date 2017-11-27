<?php

namespace Tests\Unit;

use App\Minute;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class MinuteTest extends TestCase
{

	use DatabaseMigrations, DatabaseTransactions;

	// public function setUp()
	// {
	// 	parent::setUp();
	// }

    /** @test  */
    public function it_doesnt_log_entranceless_logs()
    {
    	$member = $this->savedNewMember();

		$leaving = $member->visits()->save($this->newVisitLogOutside(['created_at' => Carbon::now()]));

		$result = Minute::keep($member, $leaving);

		$this->assertFalse($result);
    }

    /** @test  */
    public function it_loggs_less_zero_minutes()
    {
    	$member = $this->savedNewMember();

		$entrance = $member->visits()->save($this->newVisitLogInside(['created_at' => Carbon::now()]));
		$leaving = $member->visits()->save($this->newVisitLogOutside(['created_at' => Carbon::now()]));

		$result = Minute::keep($member, $leaving);

		$this->assertEquals(1, $result);

		$this->assertDatabaseMissing('minutes', [
			'member_id' => $member->id,
			'day' => $leaving->created_at->format('Y-m-d'),
			'week_day' => $leaving->created_at->format('w'),
			'minutes' => 0,
		]);

		$this->assertEquals(1, $leaving->getEntrance()->processed);
		$this->assertEquals(1, $leaving->processed);
    }

    /** @test  */
    public function it_loggs_60_minutes()
    {
		$member = $this->savedNewMember();

		$time = Carbon::createFromDate(2017, 2, 18);
		$time->startOfDay()->addHours(10)->addMinutes(18);

		$entrance = $member->visits()->save($this->newVisitLogInside([
			'created_at' => $time->copy()
		]));
		$leaving = $member->visits()->save($this->newVisitLogOutside([
			'created_at' => $time->copy()->addMinutes(60)
		]));

		$result = Minute::keep($member, $leaving);

		$this->assertEquals(1, $result);

		$this->assertDatabaseHas('minutes', [
			'member_id' => $member->id,
			'day' => $leaving->created_at->format('Y-m-d'),
			'week_day' => $leaving->created_at->format('w'),
			'minutes' => 60,
		]);

		$this->assertEquals(1, $leaving->getEntrance()->processed);
		$this->assertEquals(1, $leaving->processed);
    }

    /** @test  */
    public function it_loggs_60_minutes_twice_a_day()
    {
		$member = $this->savedNewMember();

		$time1 = Carbon::createFromDate(2017, 2, 18)->startOfDay()->addHours(12);
		$time2 = Carbon::createFromDate(2017, 2, 18)->startOfDay()->addHours(12);
		$time3 = Carbon::createFromDate(2017, 2, 18)->startOfDay()->addHours(12);
		$time4 = Carbon::createFromDate(2017, 2, 18)->startOfDay()->addHours(12);

		$entrance = $member->visits()->save($this->newVisitLogInside(['created_at' => $time1->subMinutes(180)]));
		$leaving = $member->visits()->save($this->newVisitLogOutside(['created_at' => $time2->subMinutes(120)]));
		$entrance2 = $member->visits()->save($this->newVisitLogInside(['created_at' => $time3->subMinutes(60)]));
		$leaving2 = $member->visits()->save($this->newVisitLogOutside(['created_at' => $time4]));

		$result = Minute::keep($member, $leaving);

		$result2 = Minute::keep($member, $leaving2);

		$this->assertEquals(1, $result);

		$this->assertDatabaseHas('minutes', [
			'member_id' => $member->id,
			'day' => $leaving->created_at->format('Y-m-d'),
			'week_day' => $leaving->created_at->format('w'),
			'minutes' => 120,
		]);

		$this->assertEquals(1, $leaving->getEntrance()->processed);
		$this->assertEquals(1, $leaving->processed);
    }

    /** @test  */
    public function it_loggs_two_dates()
    {
		$member = $this->savedNewMember();

		$time = Carbon::createFromDate(2017, 2, 18);
		$time->startOfDay()->addHours(10)->addMinutes(18);

		$entrance = $member->visits()->save($this->newVisitLogInside([
			'created_at' => $time->copy()
		]));
		$leaving = $member->visits()->save($this->newVisitLogOutside([
			'created_at' => $time->copy()->addDay()
		]));

		$result = Minute::keep($member, $leaving);

		$entrance_end_day = $entrance->created_at;
		$leaving_start_day = $leaving->created_at;

		$this->assertEquals(2, $result);

		$this->assertDatabaseHas('minutes', [
			'member_id' => $member->id,
			'day' => $entrance->created_at->format('Y-m-d'),
			'week_day' => $entrance->created_at->format('w'),
			'minutes' => 821,
		]);

		$this->assertDatabaseHas('minutes', [
			'member_id' => $member->id,
			'day' => $leaving->created_at->format('Y-m-d'),
			'week_day' => $leaving->created_at->format('w'),
			'minutes' => 618,
		]);

		$this->assertEquals(1, $leaving->getEntrance()->processed);
		$this->assertEquals(1, $leaving->processed);
    }

    /** @test  */
    public function it_loggs_three_dates()
    {
		$member = $this->savedNewMember();

		$time = Carbon::createFromDate(2017, 2, 18);
		$time->startOfDay()->addHours(10)->addMinutes(18);

		$entrance = $member->visits()->save($this->newVisitLogInside([
			'created_at' => $time->copy()
		]));
		$leaving = $member->visits()->save($this->newVisitLogOutside([
			'created_at' => $time->copy()->addDays(2)
		]));

		$result = Minute::keep($member, $leaving);

		$entrance_end_day = $entrance->created_at;
		$leaving_start_day = $leaving->created_at;

		$this->assertEquals(3, $result);

		$this->assertDatabaseHas('minutes', [
			'member_id' => $member->id,
			'day' => $entrance->created_at->format('Y-m-d'),
			'week_day' => $entrance->created_at->format('w'),
			'minutes' => 821,
		]);

		$this->assertDatabaseHas('minutes', [
			'member_id' => $member->id,
			'day' => $entrance->created_at->copy()->addDay()->format('Y-m-d'),
			'week_day' => $entrance->created_at->copy()->addDay()->format('w'),
			'minutes' => 1439,
		]);

		$this->assertDatabaseHas('minutes', [
			'member_id' => $member->id,
			'day' => $leaving->created_at->format('Y-m-d'),
			'week_day' => $leaving->created_at->format('w'),
			'minutes' => 618,
		]);

		$this->assertEquals(1, $leaving->getEntrance()->processed);
		$this->assertEquals(1, $leaving->processed);
    }
}
