<?php declare(strict_types=1);

namespace Avram;

class API
{
    protected $schema;

    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }

    public function render($query)
    {
        $field = $query['field'] ?? '';

        if ($field === '') {
            $response = $this->schema;
        } else {
            $response = $this->schema->lookupField($params['*']);
        }

        if (!$response) {
            http_response_code(404);
            $response = [ 'message' => 'Not found' ];
        }

        header('Content-Type: application/json; charset=UTF-8');
        header('Access-Control-Allow-Origin *');

        echo json_encode($response, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT |
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
