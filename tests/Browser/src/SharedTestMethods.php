<?php

namespace Tests\Browser\src;

use Laravel\Dusk\Browser;


trait SharedTestMethods
{
    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testAspect(Browser $browser)
    {
        $browser->assertAttributeContains('#aspect-wrapper', 'class', 'bg-green-300')
            ->click('#aspect-selectized')
            ->keys('#aspect-selectized', '16:9', ['{ENTER}'])
            ->screenShot('aspect')
            ->assertAttributeContains('#aspect-wrapper', 'class', 'bg-green-700')
            ->assertAttributeContains('#aspect-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --aspect 16:9')
            ->doubleClick('#aspect-selectized')
            ->keys('#aspect-selectized', ['{BACKSPACE}'])
            ->click('#prompt-text')
            ->assertAttributeContains('#aspect-wrapper', 'class', 'bg-green-300')
            ->assertAttributeContains('#aspect-wrapper label', 'class', 'text-gray-600')
            ->screenShot('aspect');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testChaos(Browser $browser)
    {
        $browser->assertAttributeContains('#chaos-wrapper', 'class', 'bg-green-300')
            ->type('chaos', '50')
            ->keys('#chaos', ['{TAB}'])
            ->assertAttributeContains('#chaos-wrapper', 'class', 'bg-green-700')
            ->assertAttributeContains('#chaos-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --chaos 50')
            ->doubleClick('#chaos')
            ->keys('#chaos', ['{BACKSPACE}'])
            ->click('#prompt-text')
            ->assertAttributeContains('#chaos-wrapper', 'class', 'bg-green-300')
            ->assertAttributeContains('#chaos-wrapper label', 'class', 'text-gray-600')
            ->screenShot('chaos');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testQuality(Browser $browser)
    {
        $browser->assertAttributeContains('#quality-wrapper', 'class', 'bg-green-300')
            ->click('#quality-selectized')
            ->keys('#quality-selectized', '1', ['{ENTER}'])
            ->screenShot('quality')
            ->assertAttributeContains('#quality-wrapper', 'class', 'bg-green-700')
            ->assertAttributeContains('#quality-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --quality 1')
            ->doubleClick('#quality-selectized')
            ->keys('#quality-selectized', ['{BACKSPACE}'])
            ->click('#prompt-text')
            ->assertAttributeContains('#quality-wrapper', 'class', 'bg-green-300')
            ->assertAttributeContains('#quality-wrapper label', 'class', 'text-gray-600')
            ->screenShot('quality');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testNo(Browser $browser)
    {
        $browser->assertAttributeContains('#no-wrapper', 'class', 'bg-green-300')
            ->type('no', 'no trees or bushes')
            ->keys('#no', ['{TAB}'])
            ->assertAttributeContains('#no-wrapper', 'class', 'bg-green-700')
            ->assertAttributeContains('#no-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --no no trees or bushes')
            ->keys('#no', ['{CONTROL}', 'a'])
            ->keys('#no', ['{BACKSPACE}'])
            ->click('#prompt-text')
            ->assertAttributeContains('#no-wrapper', 'class', 'bg-green-300')
            ->assertAttributeContains('#no-wrapper label', 'class', 'text-gray-600')
            ->screenShot('no');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testSeed(Browser $browser)
    {
        $browser->assertAttributeContains('#seed-wrapper', 'class', 'bg-green-300')
            ->type('seed', '50')
            ->keys('#seed', ['{TAB}'])
            ->assertAttributeContains('#seed-wrapper', 'class', 'bg-green-700')
            ->assertAttributeContains('#seed-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --seed 50')
            ->doubleClick('#seed')
            ->keys('#seed', ['{BACKSPACE}'])
            ->click('#prompt-text')
            ->assertAttributeContains('#seed-wrapper', 'class', 'bg-green-300')
            ->assertAttributeContains('#seed-wrapper label', 'class', 'text-gray-600')
            ->screenShot('seed');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testStop(Browser $browser)
    {
        $browser->assertAttributeContains('#stop-wrapper', 'class', 'bg-green-300')
            ->type('stop', '50')
            ->keys('#stop', ['{TAB}'])
            ->assertAttributeContains('#stop-wrapper', 'class', 'bg-green-700')
            ->assertAttributeContains('#stop-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --stop 50')
            ->doubleClick('#stop')
            ->keys('#stop', ['{BACKSPACE}'])
            ->click('#prompt-text')
            ->assertAttributeContains('#stop-wrapper', 'class', 'bg-green-300')
            ->assertAttributeContains('#stop-wrapper label', 'class', 'text-gray-600')
            ->screenShot('stop');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testStyle(Browser $browser)
    {
        $browser->assertAttributeContains('#style-wrapper', 'class', 'bg-green-300')
            ->click('#style-selectized')
            ->keys('#style-selectized', '4b', ['{ENTER}'])
            ->screenShot('style')
            ->assertAttributeContains('#style-wrapper', 'class', 'bg-green-700')
            ->assertAttributeContains('#style-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --style 4b')
            ->doubleClick('#style-selectized')
            ->keys('#style-selectized', ['{BACKSPACE}'])
            ->click('#prompt-text')
            ->assertAttributeContains('#style-wrapper', 'class', 'bg-green-300')
            ->assertAttributeContains('#style-wrapper label', 'class', 'text-gray-600')
            ->screenShot('style');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testVersion(Browser $browser)
    {
        $browser->assertAttributeContains('#version-wrapper', 'class', 'bg-green-300')
            ->click('#version-selectized')
            ->keys('#version-selectized', '4', ['{ENTER}'])
            ->screenShot('version')
            ->assertAttributeContains('#version-wrapper', 'class', 'bg-green-700')
            ->assertAttributeContains('#version-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --version 4')
            ->doubleClick('#version-selectized')
            ->keys('#version-selectized', ['{BACKSPACE}'])
            ->click('#prompt-text')
            ->assertAttributeContains('#version-wrapper', 'class', 'bg-green-300')
            ->assertAttributeContains('#version-wrapper label', 'class', 'text-gray-600')
            ->screenShot('version');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testStylize(Browser $browser)
    {
        $browser->assertAttributeContains('#stylize-wrapper', 'class', 'bg-green-300')
            ->type('stylize', '25')
            ->keys('#stylize', ['{TAB}'])
            ->assertAttributeContains('#stylize-wrapper', 'class', 'bg-green-700')
            ->assertAttributeContains('#stylize-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --stylize 25')
            ->keys('#stylize', ['{CONTROL}', 'a'])
            ->keys('#stylize', ['{BACKSPACE}'])
            ->click('#prompt-text')
            ->assertAttributeContains('#stylize-wrapper', 'class', 'bg-green-300')
            ->assertAttributeContains('#stylize-wrapper label', 'class', 'text-gray-600')
            ->screenShot('stylize');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testIw(Browser $browser)
    {
        $browser->assertAttributeContains('#iw-wrapper', 'class', 'bg-green-300')
            ->type('iw', '25')
            ->keys('#iw', ['{TAB}'])
            ->assertAttributeContains('#iw-wrapper', 'class', 'bg-green-700')
            ->assertAttributeContains('#iw-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --iw 25')
            ->keys('#iw', ['{CONTROL}', 'a'])
            ->keys('#iw', ['{BACKSPACE}'])
            ->click('#prompt-text')
            ->assertAttributeContains('#iw-wrapper', 'class', 'bg-green-300')
            ->assertAttributeContains('#iw-wrapper label', 'class', 'text-gray-600')
            ->screenShot('iw');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testTile(Browser $browser)
    {
        $browser->assertAttributeContains('#tile-wrapper', 'class', 'bg-green-300')
            ->check('tile')
            ->assertAttributeContains('#tile-wrapper', 'class', 'bg-green-700')
            ->assertAttributeContains('#tile-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --tile')
            ->click('#prompt-text')
            ->uncheck('tile')
            ->assertValueIsNot('#prompt', ' --tile')
            ->assertAttributeContains('#tile-wrapper', 'class', 'bg-green-300')
            ->assertAttributeContains('#tile-wrapper label', 'class', 'text-gray-600')
            ->screenShot('tile');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testNiji(Browser $browser)
    {
        $browser->assertAttributeContains('#niji-wrapper', 'class', 'bg-sky-300')
            ->check('niji')
            ->assertAttributeContains('#niji-wrapper', 'class', 'bg-sky-700')
            ->assertAttributeContains('#niji-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --niji')
            ->click('#prompt-text')
            ->uncheck('niji')
            ->assertValueIsNot('#prompt', ' --niji')
            ->assertAttributeContains('#niji-wrapper', 'class', 'bg-sky-300')
            ->assertAttributeContains('#niji-wrapper label', 'class', 'text-gray-600')
            ->screenShot('niji');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testHd(Browser $browser)
    {
        $browser->assertAttributeContains('#hd-wrapper', 'class', 'bg-sky-300')
            ->check('hd')
            ->assertAttributeContains('#hd-wrapper', 'class', 'bg-sky-700')
            ->assertAttributeContains('#hd-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --hd')
            ->click('#prompt-text')
            ->uncheck('hd')
            ->assertValueIsNot('#prompt', ' --hd')
            ->assertAttributeContains('#hd-wrapper', 'class', 'bg-sky-300')
            ->assertAttributeContains('#hd-wrapper label', 'class', 'text-gray-600')
            ->screenShot('hd');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testTest(Browser $browser)
    {
        $browser->assertAttributeContains('#test-wrapper', 'class', 'bg-sky-300')
            ->check('test')
            ->assertAttributeContains('#test-wrapper', 'class', 'bg-sky-700')
            ->assertAttributeContains('#test-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --test')
            ->click('#prompt-text')
            ->uncheck('test')
            ->assertValueIsNot('#prompt', ' --test')
            ->assertAttributeContains('#test-wrapper', 'class', 'bg-sky-300')
            ->assertAttributeContains('#test-wrapper label', 'class', 'text-gray-600')
            ->screenShot('test');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testTestp(Browser $browser)
    {
        $browser->assertAttributeContains('#testp-wrapper', 'class', 'bg-sky-300')
            ->check('testp')
            ->assertAttributeContains('#testp-wrapper', 'class', 'bg-sky-700')
            ->assertAttributeContains('#testp-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --testp')
            ->click('#prompt-text')
            ->uncheck('testp')
            ->assertValueIsNot('#prompt', ' --testp')
            ->assertAttributeContains('#testp-wrapper', 'class', 'bg-sky-300')
            ->assertAttributeContains('#testp-wrapper label', 'class', 'text-gray-600')
            ->screenShot('testp');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testUplight(Browser $browser)
    {
        $browser->assertAttributeContains('#uplight-wrapper', 'class', 'bg-pink-300')
            ->check('uplight')
            ->assertAttributeContains('#uplight-wrapper', 'class', 'bg-pink-700')
            ->assertAttributeContains('#uplight-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --uplight')
            ->click('#prompt-text')
            ->uncheck('uplight')
            ->assertValueIsNot('#prompt', ' --uplight')
            ->assertAttributeContains('#uplight-wrapper', 'class', 'bg-pink-300')
            ->assertAttributeContains('#uplight-wrapper label', 'class', 'text-gray-600')
            ->screenShot('uplight');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testUpbeta(Browser $browser)
    {
        $browser->assertAttributeContains('#upbeta-wrapper', 'class', 'bg-pink-300')
            ->check('upbeta')
            ->assertAttributeContains('#upbeta-wrapper', 'class', 'bg-pink-700')
            ->assertAttributeContains('#upbeta-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --upbeta')
            ->click('#prompt-text')
            ->uncheck('upbeta')
            ->assertValueIsNot('#prompt', ' --upbeta')
            ->assertAttributeContains('#upbeta-wrapper', 'class', 'bg-pink-300')
            ->assertAttributeContains('#upbeta-wrapper label', 'class', 'text-gray-600')
            ->screenShot('upbeta');
    }

    /**
     * @param Browser $browser
     * @return void
     * @throws \Facebook\WebDriver\Exception\ElementClickInterceptedException
     * @throws \Facebook\WebDriver\Exception\NoSuchElementException
     */
    protected function testUpanime(Browser $browser)
    {
        $browser->assertAttributeContains('#upanime-wrapper', 'class', 'bg-pink-300')
            ->check('upanime')
            ->assertAttributeContains('#upanime-wrapper', 'class', 'bg-pink-700')
            ->assertAttributeContains('#upanime-wrapper label', 'class', 'text-gray-200')
            ->assertValue('#prompt', ' --upanime')
            ->click('#prompt-text')
            ->uncheck('upanime')
            ->assertValueIsNot('#prompt', ' --upanime')
            ->assertAttributeContains('#upanime-wrapper', 'class', 'bg-pink-300')
            ->assertAttributeContains('#upanime-wrapper label', 'class', 'text-gray-600')
            ->screenShot('upanime');
    }
}
