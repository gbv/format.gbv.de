<?php declare(strict_types=1);

namespace Avram;

class SchemaTest extends \PHPUnit\Framework\TestCase
{
    public function testSchema()
    {
        $json = file_get_contents('tests/Avram/example.json');
        $schema = new Schema(json_decode($json));

        $this->assertSame(null, $schema->lookupField('42'));
        $this->assertEquals(
            (object)['label'=>'Library of Congress Control Number'],
            $schema->lookupField('010')
        );
    }
}
