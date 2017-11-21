<?php

use App\Member;
use App\VisitLog;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class VisitLogTest extends TestCase
{

	use DatabaseMigrations;

	/** @test */
	public function it_gets_the_entrance()
	{
		$member = factory(Member::class)->create();

		$first_entrance = $member->visits()->save(factory(VisitLog::class)->states('inside')->create());
		$first_leaving = $member->visits()->save(factory(VisitLog::class)->states('outside')->create());
		$second_entrance = $member->visits()->save(factory(VisitLog::class)->states('inside')->create());
		$second_leaving = $member->visits()->save(factory(VisitLog::class)->states('outside')->create());

		$this->assertEquals($first_entrance->id, $first_leaving->getEntrance()->id);
		$this->assertNotEquals($second_entrance->id, $first_leaving->getEntrance()->id);
	}

	/** @test */
	public function it_gets_the_leaving()
	{
		$member = factory(Member::class)->create();

		$first_entrance = $member->visits()->save(factory(VisitLog::class)->states('inside')->create());
		$first_leaving = $member->visits()->save(factory(VisitLog::class)->states('outside')->create());
		$second_entrance = $member->visits()->save(factory(VisitLog::class)->states('inside')->create());
		$second_leaving = $member->visits()->save(factory(VisitLog::class)->states('outside')->create());

		$this->assertEquals($first_leaving->id, $first_entrance->getLeaving()->id);
		$this->assertNotEquals($second_leaving->id, $first_entrance->getLeaving()->id);
	}
}
