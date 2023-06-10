<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use Tests\Browser\src\createAccountMethod;
use Tests\Browser\src\SharedTestMethods;

class profileTest extends DuskTestCase
{
    use SharedTestMethods;
    use createAccountMethod;

    public function testFreeAccountProfile()
    {
        $name = 'Free Profile';
        $email = 'freeProfile@pg.com';
        $password = 'password';
        $accountSlug = 'Free Account';

        $this->testCreateAccount($name, $email, $password, $accountSlug);
        $this->testProfileAccount($name, $email, $password, $accountSlug);
        $this->testPasswordAccount($name, $email, $password, $accountSlug);
        $this->testDeleteAccount($name, $email, $password, $accountSlug);
    }

    public function testTestAccountProfile()
    {
        $name = 'Test Profile';
        $email = 'TestProfile@pg.com';
        $password = 'password';
        $accountSlug = 'tester';

        $this->testCreateAccount($name, $email, $password, $accountSlug);
        $this->testPurchaseAccount($name, $email, $password, $accountSlug);
        $this->testProfileAccount($name, $email, $password, $accountSlug);
        $this->testPasswordAccount($name, $email, $password, $accountSlug);
        $this->testDeleteAccount($name, $email, $password, $accountSlug);
    }

    public function testUserAccountProfile()
    {
        $name = 'User Profile';
        $email = 'UserProfile@pg.com';
        $password = 'password';
        $accountSlug = 'monthly-user';

        $this->testCreateAccount($name, $email, $password, $accountSlug);
        $this->testPurchaseAccount($name, $email, $password, $accountSlug);
        $this->testProfileAccount($name, $email, $password, $accountSlug);
        $this->testPasswordAccount($name, $email, $password, $accountSlug);
        $this->testDeleteAccount($name, $email, $password, $accountSlug);
    }

    public function testProAccountProfile()
    {
        $name = 'Pro Profile';
        $email = 'ProProfile@pg.com';
        $password = 'password';
        $accountSlug = 'monthly-pro';

        $this->testCreateAccount($name, $email, $password, $accountSlug);
        $this->testPurchaseAccount($name, $email, $password, $accountSlug);
        $this->testProfileAccount($name, $email, $password, $accountSlug);
        $this->testPasswordAccount($name, $email, $password, $accountSlug);
        $this->testDeleteAccount($name, $email, $password, $accountSlug);
    }
}
