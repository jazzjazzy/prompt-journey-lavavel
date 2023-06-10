<?php

namespace Tests\Browser\src;

use Laravel\Dusk\Browser;


trait createAccountMethod
{
    protected function testCreateAccount(string $name, string $email, string $password, string $accountSlug)
    {
        $this->browse(function (Browser $browser) use ($name, $email, $password, $accountSlug) {
            $browser->visit('/')
                ->assertPathIs('/login') // goto login page
                ->assertSee('REGISTER NOW')
                ->click('#register') // goto register page
                ->assertPathIs('/register')
                ->type('name', $name)
                ->type('email', $email)
                ->type('password', $password)
                ->type('password_confirmation', $password)
                ->click('#register-save')
                ->assertPathIs('/dashboard') // check we at dashboard page
                ->assertSee($name);
        });
    }

    protected function testPurchaseAccount(string $name, string $email, string $password, string $accountSlug)
    {
        switch ($accountSlug) {
            case 'tester':
                $title = 'Tester';
                $price = '$3';
                $gotobutton = '/dashboard';
                break;
            case 'monthly-user':
                $title = 'Monthly User';
                $price = '$3';
                $gotobutton = '/projects';
                break;
            case 'monthly-pro':
                $title = 'Monthly Pro';
                $price = '$6';
                $gotobutton = '/projects';
                break;
            default:
                $title = '';
                $price = '';
                break;
        }

        $nextYear = date('y') + 1;

        $this->browse(function (Browser $browser) use ($name, $email, $password, $accountSlug, $title, $price, $nextYear, $gotobutton) {
            $browser->assertPathIs('/dashboard')
                ->assertSee($name)
                ->clickLink('Pricing')
                ->assertPathIs('/pricing')
                ->assertSee('Free')
                ->assertSee('Choose a subscription plan')
                ->click('#purchase-' . $accountSlug)
                ->assertPathIs('/subscribe/' . $accountSlug)
                ->assertSee($title)
                ->assertSee($price)
                ->value('#card-holder-name', $name)
                ->pause(2000)
                ->waitFor('#card-number-element iframe') // Wait for the iframe within the div with id 'card-number-element'
                ->withinFrame('#card-number-element iframe', function (Browser $iframe) {
                    $iframe->waitFor('input[name="cardnumber"]') //wait for cc number iframe to load
                    ->type('input[name="cardnumber"]', '4000000360000006');// add cc card
                })
                ->withinFrame('#card-expiry-element iframe', function (Browser $iframe) use ($nextYear) {
                    $iframe->waitFor('input[name="exp-date"]') //wait for expire date iframe to load
                    ->type('input[name="exp-date"]', '12/' . $nextYear); //add expire date
                })
                ->withinFrame('#card-cvc-element iframe', function (Browser $iframe) {
                    $iframe->waitFor('input[name="cvc"]') //wait for cvc iframe to load
                    ->type('input[name="cvc"]', '123');  //add cvc
                })
                ->value('#postal-code', '3078')
                ->click("#submit-button")
                ->pause(4000) //wait for stripe to process
                ->assertSee($title)
                ->assertSee($price)
                ->press('#goto-button')
                ->assertPathIs($gotobutton)
                ->screenshot('cc');
        });
    }

    protected function testProfileAccount(string $name, string $email, string $password, string $accountSlug)
    {
        $this->browse(function (Browser $browser) use ($name, $email, $password, $accountSlug) {
            $newName = $name . '-test';
            $newEmail = 'test-' . $email;

            if ($accountSlug === 'monthly-user' || $accountSlug === 'monthly-pro') {
                // if we have monthly account we coming from the projects page
                $browser->assertPathIs('/projects')
                    ->clickLink('Default') // go to dashboard
                    ->screenshot('projects')
                    ->assertPathBeginsWith('/dashboard')
                    ->screenshot('dashboard');
            }

            $browser->assertPathBeginsWith('/dashboard') // check we at dashboard page
            ->assertSee($name)
                ->click('#profile-menu')
                ->click('#profile')
                ->assertPathIs('/profile')
                ->assertValue('#name', $name)// is expected value
                ->assertValue('#email', $email)
                ->value('#name', $newName) // set new value
                ->value('#email', $newEmail)
                ->press('#profile-save') //save new value
                ->assertPathIs('/profile') // check path
                ->assertSee($newName)
                ->assertValue('#name', $newName)// is expected value
                ->assertValue('#email', $newEmail)
                ->clickLink('Prompt Journey'); // check name in dashboard

            if ($accountSlug === 'monthly-user' || $accountSlug === 'monthly-pro') {
                // if we have monthly account we coming from the projects page
                $browser->assertPathIs('/projects')
                    ->clickLink('Default') // go to dashboard
                    ->screenshot('projects')
                    ->assertPathBeginsWith('/dashboard')
                    ->screenshot('dashboard');
            }

            $browser->assertPathBeginsWith('/dashboard')
                ->assertSee($newName)
                ->click('#profile-menu') //go bach to profile
                ->click('#profile')
                ->assertPathIs('/profile')
                ->value('#name', $name) // set old value
                ->value('#email', $email)
                ->press('#profile-save'); //save old value
        });
    }

    protected function testPasswordAccount(string $name, string $email, string $password, string $accountSlug)
    {
        $this->browse(function (Browser $browser) use ($name, $email, $password, $accountSlug) {
            $newPassword = $password . '-test';

            $browser->assertPathIs('/profile')
                ->assertValue('#current_password', '') // check it is empty
                ->assertValue('#password', '')
                ->assertValue('#password_confirmation', '')
                ->click('#password-save') // test validation on empty fields
                ->assertSee('The current password field is required.')
                ->assertSee('The password field is required.')
                ->value('#password', 'aaa') // test validation on short password and no current password
                ->scrollTo('#password-save')->click('#password-save')
                ->assertSee('The current password field is required.')
                ->assertSee('The password must be at least 8 characters.')
                ->assertSee('The password confirmation does not match.')
                ->value('#current_password', $password)// test validation on short password with current password
                ->value('#password', 'aaa')
                ->scrollTo('#password-save')->click('#password-save')
                ->assertSee('The password must be at least 8 characters.')
                ->assertSee('The password confirmation does not match.')
                ->value('#current_password', $password)// test confirm password not match
                ->value('#password', $newPassword)
                ->value('#password_confirmation', $newPassword . '2')
                ->scrollTo('#password-save')->click('#password-save')
                ->assertSee('The password confirmation does not match.')
                ->value('#current_password', $password)// change current password
                ->value('#password', $newPassword)
                ->value('#password_confirmation', $newPassword)
                ->scrollTo('#password-save')->click('#password-save')
                ->click('#profile-menu') // logout
                ->click('#logout')
                ->assertPathIs('/login') // login with new password
                ->assertSee('REGISTER NOW')
                ->type('email', $email)
                ->type('password', $newPassword)
                ->press('LOG IN');

            if ($accountSlug === 'monthly-user' || $accountSlug === 'monthly-pro') {
                // if we have monthly account we coming from the projects page
                $browser->assertPathIs('/projects')
                    ->clickLink('Default') // go to dashboard
                    ->screenshot('projects')
                    ->assertPathBeginsWith('/dashboard')
                    ->screenshot('dashboard');
            }

            $browser->assertPathBeginsWith('/dashboard')
                ->assertSee($name)
                ->click('#profile-menu') // go to profile
                ->pause(500)
                ->click('#profile')
                ->assertPathIs('/profile')
                ->value('#current_password', $newPassword) // reset password to old password
                ->value('#password', $password)
                ->value('#password_confirmation', $password)
                ->scrollTo('#password-save')->click('#password-save');
        });
    }

    protected function testDeleteAccount(string $name, string $email, string $password, string $accountSlug)
    {
        $this->browse(function (Browser $browser) use ($name, $email, $password, $accountSlug) {
            $newPassword = $password . '-test';

            $browser->assertPathIs('/profile')
                ->scrollTo('#delete-account')
                ->pressAndWaitFor('#delete-account', .5) // test delete cancel
                ->waitForText('Are you sure you want to delete your account?')
                ->press('#delete-account-cancel')
                ->pause(1000)
                ->assertDontSee('Are you sure you want to delete your account?')
                ->scrollTo('#delete-account')
                ->pressAndWaitFor('#delete-account') // test delete without password
                ->waitForText('Are you sure you want to delete your account?')
                ->scrollTo('#delete-account-modal')
                ->screenshot('delete-no-password 2')
                ->press('#delete-account-modal')
                ->assertSee('The password field is required.')
                ->value('#delete-password', $newPassword) // test delete with wrong password
                ->press('#delete-account-modal')
                ->assertSee('The password is incorrect.')
                ->value('#delete-password', $password) // delete account
                ->press('#delete-account-modal')
                ->assertPathIs('/login') // check we are at login page
                ->assertSee('REGISTER NOW')
                ->type('email', $email)
                ->type('password', $password)
                ->press('LOG IN');
        });
    }
}
