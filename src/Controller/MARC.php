<?php declare(strict_types=1);

namespace Controller;

use GBV\JsonResponse;
use GBV\MARC\Field;
use GBV\NotFoundException;


class MARC
{

    public function error($f3)
    {
        error_log(print_r($f3['ERROR'], true));
        $response = new JsonResponse([], $f3['ERROR.code']);
        $response->send();
    }

    public function render($f3, $params)
    {
        $f3->set('ONERROR', function ($f3) {
            $this->error($f3);
        });

        $path = $params['*'];
        $field = new Field($path);
        if (empty($field->getData())) {
            throw new NotFoundException();
        }
        $response = new JsonResponse($field->getData());
        $response->send();
    }
}
