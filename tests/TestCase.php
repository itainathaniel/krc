<?php

namespace Tests;

use App\Member;
use App\VisitLog;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $baseUrl = 'https://krc.dev';

    public function newMember($params = [])
    {
        return factory(Member::class)->make($params);
    }

    public function savedNewMember($params = [])
    {
        $member = $this->newMember();
        $member->save();

        return $member;
    }

    public function newVisitLogInside($params = [])
    {
        return factory(VisitLog::class)
            ->states('inside')
            ->create($params);
    }

    public function newVisitLogOutside($params = [])
    {
        return factory(VisitLog::class)
            ->states('outside')
            ->create($params);
    }
}
