<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use mytcms\Tags;

class MytcmsTest extends TestCase
{

    public function testTags()
    {
        $tags = new Tags('tests/tags', ['a' => 4]);
        $this->assertSame('42!', $tags->expand('<a-b b="2"/>!'));
        $this->assertSame("42\n4!", $tags->expand("<foo a='?' b='!'>42\n</foo>"));
    }
}
