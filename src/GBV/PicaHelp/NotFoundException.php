<?php

namespace GBV\PicaHelp;

/**
 * Exception to be thrown if help could not be found.
 *
 * @package     PicaHelp
 * @author      Karsten Achterrath <karsten.achterrath@gbv.de>
 * @copyright   GBV VZG <https://www.gbv.de>
 * @license     GPLv3 <https://www.gnu.org/licenses/gpl-3.0.txt>
 */
class NotFoundException extends \Exception
{
    public function __construct() {
        parent::__construct('Not Found', 404);
    }
}
