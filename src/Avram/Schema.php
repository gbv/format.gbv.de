<?php declare(strict_types=1);

namespace Avram;

class Schema
{
    protected $schema;

    public function __construct($schema)
    {
        $this->schema = $schema;
    }

    public function lookup(string $path)
    {
        $field = $path;
        $field = $this->schema->fields->{$field} ?? null;
        return $field;
    }
}
