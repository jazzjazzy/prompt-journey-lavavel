<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\ParameterTest;
use Tests\Browser\freeAccountLayoutTest;
use Tests\Browser\profileTest;

class ExampleTest extends DuskTestCase
{

    var $profileTest;
    var $freeAccountLayoutTest;

    var $ParameterTest;
    /**
     * A basic browser test example.
     */
    public function testBasicExample(): void
    {
        $this->profileTest = new profileTest();
        $this->profileTest->testFreeAccountProfile();
        $this->profileTest->testTestAccountProfile();
        $this->profileTest->testUserAccountProfile();
        $this->profileTest->testProAccountProfile();

        $this->freeAccountLayoutTest = new freeAccountLayoutTest();
        $this->freeAccountLayoutTest->testLoginFreeUser();
        $this->freeAccountLayoutTest->testSuffixFreeUser();
        $this->freeAccountLayoutTest->testLogout();

        $this->ParameterTest = new ParameterTest();
        $this->ParameterTest->testFreeUser();
        $this->ParameterTest->testTesterUser();
        $this->ParameterTest->testUserUser();
        $this->ParameterTest->testProUser();




    }
}
