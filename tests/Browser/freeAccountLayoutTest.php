<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Browser\WebD;
use Tests\DuskTestCase;

use Tests\Browser\src\SharedTestMethods;

class freeAccountLayoutTest extends DuskTestCase
{
    use SharedTestMethods;

    /**
     * A Dusk test example.
     */


/*    public function testTesterUser()
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
    }*/


    /**
     * A basic browser test example.
     */

    public function testLoginFreeUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertPathIs('/login')
                ->assertSee('REGISTER NOW')
                ->type('email', 'free@pj.com')
                ->type('password', 'password')
                ->press('LOG IN')
                ->assertPathIs('/dashboard')
                ->assertSee('Free Account')
                ->assertSeeLink('Pricing')
                // let make sure we don't have a projects link
                ->assertDontSeeLink('Projects');
                //or that we can get to projects
                /*->visit('/projects')
                ->assertPathIs('/dashboard');*/
        });
    }
    public function testSuffixFreeUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->assertAttributeContains('#suffix-list', 'class', 'btn-primary-disabled')
                ->assertAttributeContains('#row-view-suffix-1', 'class', 'icon-button-disabled')
                ->press('add-suffix')
                ->assertAttributeContains('#row-view-suffix-2', 'class', 'icon-button-disabled')
                ->type('suffix-1', 'man in a red car')
                ->type('suffix-2', 'with a yellow hat')
                ->check("#suffix-add-1")
                ->assertDisabled('suffix-1')
                ->assertValue('#prompt', ' man in a red car')
                ->check('#suffix-add-2')
                ->assertDisabled('suffix-2')
                ->assertValue('#prompt', ' man in a red car with a yellow hat')
                //drag jquery-ui sortable dons't seem to work in dusk
                //->dragUp('#suffixHandle-2', $pixels = 200)
                //->assertValue('#prompt', ' with a yellow hat man in a red car')
                ->uncheck('#suffix-add-1')
                ->uncheck('#suffix-add-2')
                ->assertValue('#prompt', '')
                ->press('#row-copy-suffix-1')
                ->assertSee('Suffix copied to clipboard')
                //->keys('#prompt-text',  ['{CONTROL}', 'v'])
                //->assertValue('#prompt', 'man in a red car')
                //->keys('#prompt-text', ['{CONTROL}', 'a'])
                //->keys('#prompt-text', ['{BACKSPACE}'])
                ->assertValue('#prompt', '')
                ->press('#row-copy-suffix-2')
                ->assertSee('Suffix copied to clipboard')
                ->keys('#prompt-text',  ['{CONTROL}', 'v'])
                //->assertValue('#prompt', 'with a yellow hat')
                //->keys('#prompt-text', ['{CONTROL}', 'a'])
                //->keys('#prompt-text', ['{BACKSPACE}'])
                ->assertValue('#prompt', '')
                //delete row 2
                ->press('#row-delete-suffix-2')
                ->assertSee('Suffix string deleted')
                ->assertInputMissing('#suffix-input-2')
                ->assertMissing('#suffix-add-2')
                ->assertMissing('#row-copy-suffix-2')
                ->assertMissing('#row-delete-suffix-2')
                //delete row 1
                ->press('#row-delete-suffix-1')
                ->assertSee('Suffix string deleted')
                ->assertInputValue('#suffix-input-1', '')
                ->uncheck('#suffix-add-1')
                ->screenShot('free-account-dashboard');

        });
    }


    public function testLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser->press('#profile-menu')
                ->click('#logout')
                ->assertPathIs('/login');
        });
    }
}
