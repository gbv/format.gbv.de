<?php declare(strict_types=1);

namespace Controller;

use GBV\MARC\Field;

/**
 * Controller for MARC Schema API
 */
class MARC extends JSON
{
    public function data($f3, $params)
    {
        $path = $params['*'] ?? '';
        if ($path === '') {
            return Field::getSchema();
        } else {
            $field = new Field($path);
            if (!empty($field->getData())) {
                return $field->getData();
            }
        }
    }
}
