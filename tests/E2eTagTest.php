<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class E2eTagTest extends PantherTestCase
{
    public function testTagExists(): void
    {
        // chrome
        $client = static::createPantherClient();
        // firefox
        // $client = static::createPantherClient(['browser' => static::FIREFOX]);

        $client->request('GET', '/tag/');

        $this->assertPageTitleContains('Tag index');
        $this->assertSelectorTextContains('body', 'est totam exercitationem');
    }

    public function testCanCreateNewTag(): void
    {
        $tag = 'foo bar baz';

        // chrome
        $client = static::createPantherClient();
        // firefox
        // $client = static::createPantherClient(['browser' => static::FIREFOX]);

        $client->request('GET', '/tag/');
        $client->clickLink('Create new');

        $client->submitForm('Save', [
            'tag[name]' => $tag,
            'tag[posts][]' => [1, 2],
        ]);

        $client->request('GET', '/tag/');

        $this->assertPageTitleContains('Tag index');
        $this->assertSelectorTextContains('body', $tag);
    }
}