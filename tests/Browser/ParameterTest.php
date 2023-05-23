<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use Tests\Browser\src\SharedTestMethods;

class ParameterTest extends DuskTestCase
{
    use SharedTestMethods;

    /**
     * A Dusk test example.
     */
    public function testFreeUser()
    {
        $this->testLoginExample('free@pj.com', 'password', 'Free Account');
    }

    public function testTesterUser()
    {
        $this->testLoginExample('tester@pj.com', 'password', 'Tester Account');
    }

    public function testUserUser()
    {
        $this->testLoginExample('user@pj.com', 'password', 'User Account');
    }

    public function testProUser()
    {
        $this->testLoginExample('pro@pj.com', 'password', 'Pro Account');
    }


    /**
     * A basic browser test example.
     */

    protected function testLoginExample(string $email, string $password, string $accountName)
    {
        $this->browse(function (Browser $browser) use ($email, $password, $accountName){
            $browser->visit('/')
                ->assertPathIs('/login')
                ->assertSee('REGISTER NOW')
                ->type('email', $email)
                ->type('password', $password)
                ->press('LOG IN');
                if ($accountName == 'Free Account' || $accountName == 'Tester Account') {
                    $browser->assertPathIs('/dashboard');
                } elseif ($accountName == 'User Account') {
                    $browser->assertPathIs('/projects')
                        ->assertSee('Current Projects')
                        ->assertSee('My first project')
                        ->click('#project-id-0')
                        ->assertPathIs('/dashboard/2');
                }elseif ($accountName == 'Pro Account') {
                    $browser->assertPathIs('/projects')
                        ->assertSee('Current Projects')
                        ->assertSee('My first project')
                        ->click('#project-id-0')
                        ->assertPathIs('/dashboard/13');
                }
                $browser->assertSee($accountName)
                ->press('show History')
                ->assertSee('Prompt History')
                ->press('Close');

            $this->testAspect($browser);
            $this->testQuality($browser);
            $this->testNo($browser);
            $this->testChaos($browser);
            $this->testStop($browser);
            $this->testSeed($browser);
            $this->testStyle($browser);
            $this->testVersion($browser);
            $this->testStylize($browser);
            $this->testIw($browser);
            $this->testTile($browser);
            $this->testNiji($browser);
            $this->testHd($browser);
            $this->testTest($browser);
            $this->testTestp($browser);
            $this->testUplight($browser);
            $this->testUpbeta($browser);
            $this->testUpanime($browser);

            $this->testLogout($browser);

        });
    }


    public function testLogout(Browser $browser)
    {
        $browser->press('#profile-menu')
            ->click('#logout')
            ->assertPathIs('/login');
    }
}
