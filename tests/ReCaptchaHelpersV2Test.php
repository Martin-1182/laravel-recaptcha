<?php
/**
 * Copyright (c) 2017 - present
 * LaravelGoogleRecaptcha - ReCaptchaHelpersV2Test.php
 * author: Roberto Belotti - roby.belotti@gmail.com
 * web : robertobelotti.com, github.com/biscolab
 * Initial version created on: 8/8/2019
 * MIT license: https://github.com/biscolab/laravel-recaptcha/blob/master/LICENSE
 */

namespace Biscolab\ReCaptcha\Tests;

use Biscolab\ReCaptcha\Facades\ReCaptcha;
use Biscolab\ReCaptcha\ReCaptchaBuilderV2;

class ReCaptchaHelpersV2Test extends TestCase
{

    /**
     * @test
     */
    public function testHtmlScriptTagJsApiCalledByFacade()
    {

        ReCaptcha::shouldReceive('htmlScriptTagJsApi')
            ->once()
            ->with(["key" => "val"]);

        htmlScriptTagJsApi(["key" => "val"]);

    }

    /**
     * @test
     */
    public function testHtmlFormSnippetCalledByFacade()
    {

        ReCaptcha::shouldReceive('htmlFormSnippet')
            ->once();

        htmlFormSnippet();

    }

    /**
     * @test
     */
    public function testTagAttributes()
    {

        $recaptcha = \recaptcha();

        $tag_attributes = $recaptcha->getTagAttributes();

        $this->assertArrayHasKey('sitekey', $recaptcha->getTagAttributes());
        $this->assertArrayHasKey('theme', $recaptcha->getTagAttributes());
        $this->assertArrayHasKey('size', $tag_attributes);
        $this->assertArrayHasKey('tabindex', $tag_attributes);
        $this->assertArrayHasKey('callback', $tag_attributes);
        $this->assertArrayHasKey('expired-callback', $tag_attributes);
        $this->assertArrayHasKey('error-callback', $tag_attributes);

        $this->assertEquals($tag_attributes['sitekey'], 'api_site_key');
        $this->assertEquals($tag_attributes['theme'], 'dark');
        $this->assertEquals($tag_attributes['size'], 'compact');
        $this->assertEquals($tag_attributes['tabindex'], '2');
        $this->assertEquals($tag_attributes['callback'], 'callbackFunction');
        $this->assertEquals($tag_attributes['expired-callback'], 'expiredCallbackFunction');
        $this->assertEquals($tag_attributes['error-callback'], 'errorCallbackFunction');
    }

    /**
     * @test
     */
    public function testExpectReCaptchaInstanceOfReCaptchaBuilderV2()
    {

        $this->assertInstanceOf(ReCaptchaBuilderV2::class, \recaptcha());
    }

    /**
     * @expectedException     \Error
     */
    public function testExpectExceptionWhenGetFormIdFunctionIsCalled()
    {

        getFormId();
    }

    /**
     * @test
     */
    public function testHtmlFormSnippet()
    {

        $html_snippet = \recaptcha()->htmlFormSnippet();
        $this->assertEquals('<div class="g-recaptcha" data-sitekey="api_site_key" data-theme="dark" data-size="compact" data-tabindex="2" data-callback="callbackFunction" data-expired-callback="expiredCallbackFunction" data-error-callback="errorCallbackFunction" id="recaptcha-element"></div>',
            $html_snippet);

    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {

        $app['config']->set('recaptcha.api_site_key', 'api_site_key');
        $app['config']->set('recaptcha.version', 'v2');
        $app['config']->set('recaptcha.tag_attributes', [
            'theme'            => 'dark',
            'size'             => 'compact',
            'tabindex'         => '2',
            'callback'         => 'callbackFunction',
            'expired-callback' => 'expiredCallbackFunction',
            'error-callback'   => 'errorCallbackFunction',
        ]);
    }
}