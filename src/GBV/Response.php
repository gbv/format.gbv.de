<?php declare(strict_types=1);

namespace GBV;

class Response
{
    public static $messages = [
        200 => 'Ok',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        503 => 'Service Unavailable'
    ];
    protected $code = 200;
    protected $data = [];
    protected $jsonOptions = JSON_PRETTY_PRINT;

    public function __construct(array $data = [], int $code = 200)
    {
        $this->code = $code;
        $this->data = $data;

        // check code
        if (!isset(static::$messages[$code])) {
            $this->code = 503;
        }

        // get message
        if ($this->code != 200) {
            $this->data = [
                'code' => $this->code,
                'message' => static::$messages[$code]
            ];
        }
    }

    public function setOptions(): int
    {
        return $this->jsonOptions;
    }

    public function setOption(int $options): void
    {
        $this->jsonOptions = $options;
    }

    public function send(): void
    {
        $this->sendHeader();
        $this->sendContent();
    }

    protected function sendHeader(): void
    {
        if (!headers_sent()) {
            header('HTTP/1.1 ' . $this->code . ' ' . static::$messages[$this->code]);
            header('Content-Type: application/json; charset=UTF-8');
            header('Access-Control-Allow-Origin *');
        }
    }

    protected function sendContent(): void
    {
        echo json_encode($this->data, $this->jsonOptions);
    }
}
