<?php declare(strict_types=1);

namespace mytcms;

class MytcmsTest extends \PHPUnit\Framework\TestCase
{

    public function testTags()
    {
        $tags = new Tags('tests/mytcms/tags', ['a' => 4]);
        $this->assertSame('42!', $tags->expand('<a-b b="2"/>!'));
        $this->assertSame("42\n4!", $tags->expand("<foo a='?' b='!'>42\n</foo>"));
    }
}
