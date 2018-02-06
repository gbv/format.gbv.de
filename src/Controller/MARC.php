<?php declare(strict_types=1);

namespace Controller;

use GBV\JsonResponse;
use GBV\MARC\Field;
use GBV\NotFoundException;

/**
 * Controller for MARC api
 * @package   PicaHelpRest
 * @author    Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license   GPLv3 <https://github.com/Teralios/commentarius/blob/master/LICENSE>
 */
class MARC
{

    /**
     * @param $f3
     */
    public function error($f3)
    {
        error_log(print_r($f3['ERROR'], true));
        $response = new JsonResponse([], $f3['ERROR.code']);
        $response->send();
    }

    /**
     * @param $f3
     * @param $params
     * @throws NotFoundException
     */
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
