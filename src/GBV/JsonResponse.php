<?php declare(strict_types=1);

namespace GBV;

/**
 * Response class.
 *
 * @package     PicaHelp
 * @author      Karsten Achterrath <karsten.achterrath@gbv.de>
 * @copyright   GBV VZG <https://www.gbv.de>
 * @license     GPLv3 <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class JsonResponse
{
    /**
     * @var string[]
     */
    public static $messages = [
        200 => 'Ok',
        302 => 'Found',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        503 => 'Service Unavailable'
    ];

    /**
     * @var int
     */
    protected $code = 200;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var int
     */
    protected $jsonOptions = JSON_PRETTY_PRINT;

    /**
     * @var string
     */
    protected $redirect = '';

    /**
     * Response constructor.
     *
     * @param mixed $data
     * @param int   $code
     * @throws NotFoundException
     */
    public function __construct($data, int $code = 200)
    {
        $data = $this->handleData($data);

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
                'message' => static::$messages[$this->code]
            ];
        }
    }

    /**
     * Return options for json_encode.
     *
     * @return int
     */
    public function setOptions(): int
    {
        return $this->jsonOptions;
    }

    /**
     * Set options for json encode.
     *
     * @param int $options
     */
    public function setOption(int $options): void
    {
        $this->jsonOptions = $options;
    }

    /**
     * Send response.
     */
    public function send(): void
    {
        $this->sendHeader();

        if ($this->redirect == '') {
            $this->sendContent();
        }
    }

    /**
     * Handle data.
     *
     * @param   $data
     * @return  array|string[]
     * @throws  NotFoundException
     */
    protected function handleData($data)
    {
        return $data;
    }

    /**
     * Send headers
     */
    protected function sendHeader(): void
    {
        if (!headers_sent()) {
            header('HTTP/1.1 ' . $this->code . ' ' . static::$messages[$this->code]);
            header('Content-Type: application/json; charset=UTF-8');
            header('Access-Control-Allow-Origin *');
            if (!empty($this->redirect)) {
                header($this->redirect);
            }
        }
    }

    /**
     * Send content.
     */
    protected function sendContent(): void
    {
        echo json_encode($this->data, $this->jsonOptions);
    }
}
