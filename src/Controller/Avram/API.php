<?php declare(strict_types=1);

namespace Controller\Avram;

use Avram\Schema;
use mytcms\JSON;

class API
{
    protected $schema;

    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }

    public function render($f3, $params)
    {
        $data = $this->schema->lookup($params['*']);
        if (!$data) {
            $data = new JSON([
                'message' => 'Not found'
            ], 404);
        }
        $data->sendJson();
    }
}
