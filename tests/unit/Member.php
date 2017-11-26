<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Events\newKnessetMember;
use App\Member;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class MemberTest extends TestCase
{

	use DatabaseMigrations, DatabaseTransactions;

    /** @test  */
    public function it_creates_a_member()
    {
        Event::fake();

        $member = $this->savedNewMember();

        Event::assertDispatched(newKnessetMember::class, function ($e) use ($member) {
            return $member->wasRecentlyCreated;
        });
    }

    /** @test  */
    public function it_gets_the_name_and_name_english_attributes()
    {
        $member = $this->newMember();

        $asserted = $member->first_name . ' ' . $member->last_name;
        $asserted_english = $member->first_name_english . ' ' . $member->last_name_english;

        $this->assertEquals($asserted, $member->name);
        $this->assertEquals($asserted_english, $member->name_english);
    }
}
