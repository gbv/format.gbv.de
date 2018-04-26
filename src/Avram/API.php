<?php declare(strict_types=1);

namespace Avram;

/**
 * Query an Avram Schema via HTTP.
 */
class API
{
    public function request($schema, $query)
    {
        $field = $query['field'] ?? '';
        $format = $query['format'] ?? 'json';

        if ($field === '') {
            $response = $schema;
        } else {
            $response = $schema->lookupField($field);
        }

        if (!$response) {
            http_response_code(404);
            $response = [ 'message' => 'Not found' ];
        }

        header('Access-Control-Allow-Origin *');

        if ($format === 'text') {
            header("Content-Type: text/plain; charset=utf-8");
            echo $this->tags->avramTxt(['schema'=>$data]);
        } else {
            header('Content-Type: application/json; charset=UTF-8');
            header('Access-Control-Allow-Origin *');
            echo json_encode($response, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT
                            | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
    }
}
