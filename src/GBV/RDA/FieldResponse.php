<?php
namespace GBV\RDA;

use GBV\JsonResponse;

/**
 * Json response for rda api.
 *
 * @package   PicaHelpRest
 * @author    Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license   GPLv3 <https://github.com/Teralios/commentarius/blob/master/LICENSE>
 */
class FieldResponse extends JsonResponse
{
    /**
     * {@inheritDoc}
     * @throws \GBV\NotFoundException
     */
    public function handleData($data) {
        if (is_array($data)) {
            return $data;
        } elseif ($data instanceof Field) {
                if ($data->isPica3()) {
                    $this->code = 302;
                    $this->redirect = 'Location: ./' . $data->getField() . '/';
                } else {
                    return $data->getData();
                }
        } else {
            return [$data];
        }
    }
}
