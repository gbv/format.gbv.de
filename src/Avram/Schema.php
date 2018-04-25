<?php declare(strict_types=1);

namespace Avram;

/**
 * Stores an Avram Schema.
 */
class Schema implements \JsonSerializable
{
    protected $schema;

    public function __construct($schema = [])
    {
        $this->schema = $schema;
    }

    public function lookupField(string $identifier)
    {
        return $this->schema->fields->{$identifier} ?? null;
    }

    public function jsonSerialize()
    {
        return $this->schema;
    }
}
