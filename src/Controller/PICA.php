<?php declare(strict_types=1);

namespace Controller;

use GBV\JsonResponse;
use GBV\DB;
use GBV\NotFoundException;
use GBV\RDA\Field;
use GBV\RDA\FieldResponse;

class PICA
{

    public function error($f3)
    {
        $code = $f3->get('ERROR.code');
        error_log(print_r($f3['ERROR'], true));
        $response = new JsonResponse([], $f3['ERROR.code']);
        $response->send();
    }

    public function render($f3, $params)
    {
        $f3->set('ONERROR', function ($f3) {
            $this->error($f3);
        });

        $db = new DB($f3['configFile']);

        $type = (string) $params['type'];
        $path = (string) $params['*'];

        if ($type == 'rda') {
            try {
                $field = new Field($path, $db);
                $response = new FieldResponse($field);
                $response->send();
            } catch (NotFoundException $e) {
                $f3->error(404);
            }
        } else {
            $f3->error(404);
        }
    }
}
