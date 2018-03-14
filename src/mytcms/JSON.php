<?php declare(strict_types=1);

namespace mytcms;

/**
 * A JSON(-LD) entity to be send as HTTP Response.
 */
class JSON
{
    protected $data;
    protected $code;

    public function __construct($data, int $code = 200)
    {
        $this->data = $data;
        $this->code = $code;
    }

    // TODO: Send RDF via JSON-LD if $data has @context

    public function sendJson(int $options = 0)
    {
        if (!headers_sent()) {
            http_response_code($this->code);
            header('Content-Type: application/json; charset=UTF-8');
            header('Access-Control-Allow-Origin *');
        }
        echo json_encode($this->data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | $options);
    }
}
