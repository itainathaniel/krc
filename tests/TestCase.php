<?php

use App\Member;
use App\VisitLog;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'https://krc.dev';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function newMember($params = [])
    {
        return factory(Member::class)->create($params);
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
