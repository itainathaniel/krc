<?php

use App\Minute;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

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
    	$member = $this->newMember();

		$leaving = $member->visits()->save($this->newVisitLogOutside(['created_at' => Carbon::now()]));

		$result = Minute::keep($member, $leaving);

		$this->assertFalse($result);
    }

    /** @test  */
    public function it_loggs_less_zero_minutes()
    {
    	$member = $this->newMember();

		$entrance = $member->visits()->save($this->newVisitLogInside(['created_at' => Carbon::now()]));
		$leaving = $member->visits()->save($this->newVisitLogOutside(['created_at' => Carbon::now()]));

		$result = Minute::keep($member, $leaving);

		$this->assertEquals(1, $result);

		$this->notSeeInDatabase('minutes', [
			'member_id' => $member->id,
			'day' => $leaving->created_at->format('Y-m-d'),
			'dotw' => $leaving->created_at->format('w'),
			'minutes' => 0,
		]);

		$this->assertEquals(1, $leaving->getEntrance()->processed);
		$this->assertEquals(1, $leaving->processed);
    }

    /** @test  */
    public function it_loggs_60_minutes()
    {
		$member = $this->newMember();

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

		$this->seeInDatabase('minutes', [
			'member_id' => $member->id,
			'day' => $leaving->created_at->format('Y-m-d'),
			'dotw' => $leaving->created_at->format('w'),
			'minutes' => 60,
		]);

		$this->assertEquals(1, $leaving->getEntrance()->processed);
		$this->assertEquals(1, $leaving->processed);
    }

    /** @test  */
    public function it_loggs_60_minutes_twice_a_day()
    {
		$member = $this->newMember();

		$entrance = $member->visits()->save($this->newVisitLogInside(['created_at' => Carbon::now()->subMinutes(60)]));
		$leaving = $member->visits()->save($this->newVisitLogOutside(['created_at' => Carbon::now()]));

		$result = Minute::keep($member, $leaving);

		$result2 = Minute::keep($member, $leaving);

		$this->assertEquals(1, $result);

		$this->seeInDatabase('minutes', [
			'member_id' => $member->id,
			'day' => $leaving->created_at->format('Y-m-d'),
			'dotw' => $leaving->created_at->format('w'),
			'minutes' => 120,
		]);

		$this->assertEquals(1, $leaving->getEntrance()->processed);
		$this->assertEquals(1, $leaving->processed);
    }

    /** @test  */
    public function it_loggs_two_dates()
    {
		$member = $this->newMember();

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

		$this->seeInDatabase('minutes', [
			'member_id' => $member->id,
			'day' => $entrance->created_at->format('Y-m-d'),
			'dotw' => $entrance->created_at->format('w'),
			'minutes' => 821,
		]);

		$this->seeInDatabase('minutes', [
			'member_id' => $member->id,
			'day' => $leaving->created_at->format('Y-m-d'),
			'dotw' => $leaving->created_at->format('w'),
			'minutes' => 618,
		]);

		$this->assertEquals(1, $leaving->getEntrance()->processed);
		$this->assertEquals(1, $leaving->processed);
    }

    /** @test  */
    public function it_loggs_three_dates()
    {
		$member = $this->newMember();

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

		$this->seeInDatabase('minutes', [
			'member_id' => $member->id,
			'day' => $entrance->created_at->format('Y-m-d'),
			'dotw' => $entrance->created_at->format('w'),
			'minutes' => 821,
		]);

		$this->seeInDatabase('minutes', [
			'member_id' => $member->id,
			'day' => $entrance->created_at->copy()->addDay()->format('Y-m-d'),
			'dotw' => $entrance->created_at->copy()->addDay()->format('w'),
			'minutes' => 1439,
		]);

		$this->seeInDatabase('minutes', [
			'member_id' => $member->id,
			'day' => $leaving->created_at->format('Y-m-d'),
			'dotw' => $leaving->created_at->format('w'),
			'minutes' => 618,
		]);

		$this->assertEquals(1, $leaving->getEntrance()->processed);
		$this->assertEquals(1, $leaving->processed);
    }
}
