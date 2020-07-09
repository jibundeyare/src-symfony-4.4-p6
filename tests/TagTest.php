<?php

namespace App\Tests;

use App\Entity\Tag;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    public function testNewTagHasEmptyName()
    {
        $tag = new Tag();
        $name = $tag->getName();

        $this->assertEmpty($name);
    }

    public function testTagAssignedNameIsValid()
    {
        $name = 'Foo';
        $tag = new Tag();
        $tag->setName($name);

        $this->assertEquals($tag->getName(), $name);
    }

    public function testTagGetNameMethodExists()
    {
        $tag = new Tag();
        $this->assertTrue(is_callable([$tag, 'getName']));
    }

    public function testTagSetDescriptionMethodNotExists()
    {
        $tag = new Tag();
        $this->assertFalse(is_callable([$tag, 'setDescription']));
    }
}
