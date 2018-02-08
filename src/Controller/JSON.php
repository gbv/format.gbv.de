<?php declare(strict_types=1);

namespace Controller;

use GBV\JsonResponse;

/**
 * Base class of Controllers that render JSON.
 */
abstract class JSON
{

    public function error($f3)
    {
        error_log(print_r($f3['ERROR'], true));
        $response = new JsonResponse([], $f3['ERROR.code']);
        $response->send();
    }

    abstract public function data($f3, $params);

    public function render($f3, $params)
    {
        $f3->set('ONERROR', function ($f3) {
            $this->error($f3);
        });

        $data = $this->data($f3, $params);

        if ($data) {
            $response = new JSONResponse($data, 200);
            $response->send();
        } else {
            $f3->error(404);
        }
    }
}
