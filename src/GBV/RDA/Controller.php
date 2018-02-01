<?php
namespace GBV\RDA;

use GBV\ControllerInterface;
use GBV\DB;

/**
 * Controller for RDA api.
 *
 * @package   PicaHelpRest
 * @author    Karsten (Teralios) Achterrath
 * @copyright ©2017 - 2018 Teralios.de
 * @license   GPLv3 <https://github.com/Teralios/commentarius/blob/master/LICENSE>
 */
class Controller implements ControllerInterface
{
    /**
     * {@inheritDoc}
     */
    public function handle(string $path, DB $db): void
    {
        if (strtolower($path) == 'index.html') {
            $this->handleIndex();
            return;
        }

        $this->handleApi($path, $db);
    }

    /**
     * Handle api calls.
     *
     * @param string    $path
     * @param DB        $db
     * @throws \GBV\NotFoundException
     */
    protected function handleApi(string $path, DB $db): void
    {
        $field = new Field($path, $db);
        $response = new FieldResponse($field);
        $response->send();
    }

    /**
     * Handle index for api.
     */
    protected function handleIndex(): void
    {

    }
}
