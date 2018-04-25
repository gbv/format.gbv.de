<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Avram\Schema;
use mytcms\Util;

class AvramTest extends TestCase
{
    public function testSchema()
    {
        $schema = new Schema(Util::loadJsonYaml('tests/avram-example.json'));

        $this->assertSame(null, $schema->lookupField('42'));
        $this->assertEquals(
            (object)['label'=>'Library of Congress Control Number'],
            $schema->lookupField('010')
        );
    }
}
